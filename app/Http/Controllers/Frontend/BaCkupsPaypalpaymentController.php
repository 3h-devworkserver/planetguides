<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Page;
use App\Repositories\Frontend\User\UserContract;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use DB;
use Input;
use Paypalpayment;
use Illuminate\Http\Request;


/**
 * Class PaypalPaymentController
 * @package App\Http\Controllers
 */


  

class PaypalPaymentController extends Controller {


/**
     * object to authenticate the call.
     * @param object $_apiContext
     */
    private $_apiContext;

    /**
     * Set the ClientId and the ClientSecret.
     * @param
     *string $_ClientId
     *string $_ClientSecret
     */
    private $_ClientId = 'AfjHqydP2uiOEVIVFNU1kUXWdPpVWXp_DgNC7baOnIZ1RfGLbBTBLIPZIkb5MnW5dovtLWVxGJEf1zmW';
    private $_ClientSecret='EFW-Z7dhJFRjBOD4WK8p64bdxdBMlgWUg6Zn0pMoFkAFGjJ5tvB_ioGrHRVU3vQKk93L-S4ZbeCK3YcY';

    /*
     *   These construct set the SDK configuration dynamiclly,
     *   If you want to pick your configuration from the sdk_config.ini file
     *   make sure to update you configuration there then grape the credentials using this code :
     *   $this->_cred= Paypalpayment::OAuthTokenCredential();
    */
    public function __construct()
    {

        // ### Api Context
        // Pass in a `ApiContext` object to authenticate
        // the call. You can also send a unique request id
        // (that ensures idempotency). The SDK generates
        // a request id if you do not pass one explicitly.

        $this->_apiContext = Paypalpayment::ApiContext(config('paypal_payment.Account.ClientId'), 
                config('paypal_payment.Account.ClientSecret'));

        // Uncomment this step if you want to use per request
        // dynamic configuration instead of using sdk_config.ini

        $config = config('paypal_payment'); // Get all config items as multi dimensional array
        $flatConfig = array_dot($config); // Flatten the array with dots

        $this->_apiContext->setConfig($flatConfig);
    }

    /*
    * Process payment using credit card
    */
    
    function paymentform(){
        
        die('am here');
        
    }
    
    
    function index(Request $request){
        
        
       
        
        $this->validate($request, array(
            'gid' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'cc_type' => 'required',
            'cc_no' => 'required',
            'ccv' => 'required',
            'month' => 'required',
            'year' => 'required',
            
            )
        );
        
        $totalDays = $request->session()->get('totalDays');
        $dates     = $request->session()->get('dates');
               
        $gid = $request->gid;
        $firstname = $request->firstname;
        $lastname = $request->lastname;
        $cc_type = $request->cc_type;
        $cc_no = $request->cc_no;
        $ccv = $request->ccv;
        $month = $request->month;
        $year = $request->year;
        
        $guidePriceRow =  \DB::table('guides')->where('gid', $request->gid)->first();
           
        $guidePrice = '';
        if($guidePriceRow){
               $guidePrice = $guidePriceRow->price;
        }
       
        
        
        // ### CreditCard
        $card = Paypalpayment::creditCard();
        $card->setType($cc_type)
            ->setNumber($cc_no)
            ->setExpireMonth($month)
            ->setExpireYear($year)
            ->setCvv2($ccv)
            ->setFirstName($firstname)
            ->setLastName($lastname);

        // ### FundingInstrument
        // A resource representing a Payer's funding instrument.
        // Use a Payer ID (A unique identifier of the payer generated
        // and provided by the facilitator. This is required when
        // creating or using a tokenized funding instrument)
        // and the `CreditCardDetails`
        $fi = Paypalpayment::fundingInstrument();
        $fi->setCreditCard($card);

        // ### Payer
        // A resource representing a Payer that funds a payment
        // Use the List of `FundingInstrument` and the Payment Method
        // as 'credit_card'
        $payer = Paypalpayment::payer();
        $payer->setPaymentMethod("credit_card")
            ->setFundingInstruments(array($fi));

        $item1 = Paypalpayment::item();
        $item1->setName('Ground Coffee 40 oz')
                ->setDescription('Ground Coffee 40 oz')
                ->setCurrency('USD')
                ->setQuantity(1)
                ->setTax(0.3)
                ->setPrice(7.50);

        $item2 = Paypalpayment::item();
        $item2->setName('Granola bars')
                ->setDescription('Granola Bars with Peanuts')
                ->setCurrency('USD')
                ->setQuantity(5)
                ->setTax(0.2)
                ->setPrice(2);


        $itemList = Paypalpayment::itemList();
        $itemList->setItems(array($item1,$item2));


        $details = Paypalpayment::details();
        $details->setShipping("1.2")
                ->setTax("1.3")
                //total of items prices
                ->setSubtotal("17.5");

        //Payment Amount
        $amount = Paypalpayment::amount();
        $amount->setCurrency("USD")
                // the total is $17.8 = (16 + 0.6) * 1 ( of quantity) + 1.2 ( of Shipping).
                ->setTotal("20")
                ->setDetails($details);

        // ### Transaction
        // A transaction defines the contract of a
        // payment - what is the payment for and who
        // is fulfilling it. Transaction is created with
        // a `Payee` and `Amount` types

        $transaction = Paypalpayment::transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        // ### Payment
        // A Payment Resource; create one using
        // the above types and intent as 'sale'

        $payment = Paypalpayment::payment();

        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setTransactions(array($transaction));

        try {
            // ### Create Payment
            // Create a payment by posting to the APIService
            // using a valid ApiContext
            // The return object contains the status;
            $payment->create($this->_apiContext);
        } catch (\PPConnectionException $ex) {
            return  "Exception: " . $ex->getMessage() . PHP_EOL;
            exit(1);
        }

        dd($payment);
    }
    public function store()
    {
        // ### Address
        // Base Address object used as shipping or billing
        // address in a payment. [Optional]
        $addr= Paypalpayment::address();
        $addr->setLine1("3909 Witmer Road");
        $addr->setLine2("Niagara Falls");
        $addr->setCity("Niagara Falls");
        $addr->setState("NY");
        $addr->setPostalCode("14305");
        $addr->setCountryCode("US");
        $addr->setPhone("716-298-1822");

        // ### CreditCard
        $card = Paypalpayment::creditCard();
        $card->setType("visa")
            ->setNumber("4758411877817150")
            ->setExpireMonth("05")
            ->setExpireYear("2019")
            ->setCvv2("456")
            ->setFirstName("Joe")
            ->setLastName("Shopper");

        // ### FundingInstrument
        // A resource representing a Payer's funding instrument.
        // Use a Payer ID (A unique identifier of the payer generated
        // and provided by the facilitator. This is required when
        // creating or using a tokenized funding instrument)
        // and the `CreditCardDetails`
        $fi = Paypalpayment::fundingInstrument();
        $fi->setCreditCard($card);

        // ### Payer
        // A resource representing a Payer that funds a payment
        // Use the List of `FundingInstrument` and the Payment Method
        // as 'credit_card'
        $payer = Paypalpayment::payer();
        $payer->setPaymentMethod("credit_card")
            ->setFundingInstruments(array($fi));

        $item1 = Paypalpayment::item();
        $item1->setName('Ground Coffee 40 oz')
                ->setDescription('Ground Coffee 40 oz')
                ->setCurrency('USD')
                ->setQuantity(1)
                ->setTax(0.3)
                ->setPrice(7.50);

        $item2 = Paypalpayment::item();
        $item2->setName('Granola bars')
                ->setDescription('Granola Bars with Peanuts')
                ->setCurrency('USD')
                ->setQuantity(5)
                ->setTax(0.2)
                ->setPrice(2);


        $itemList = Paypalpayment::itemList();
        $itemList->setItems(array($item1,$item2));


        $details = Paypalpayment::details();
        $details->setShipping("1.2")
                ->setTax("1.3")
                //total of items prices
                ->setSubtotal("17.5");

        //Payment Amount
        $amount = Paypalpayment::amount();
        $amount->setCurrency("USD")
                // the total is $17.8 = (16 + 0.6) * 1 ( of quantity) + 1.2 ( of Shipping).
                ->setTotal("20")
                ->setDetails($details);

        // ### Transaction
        // A transaction defines the contract of a
        // payment - what is the payment for and who
        // is fulfilling it. Transaction is created with
        // a `Payee` and `Amount` types

        $transaction = Paypalpayment::transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        // ### Payment
        // A Payment Resource; create one using
        // the above types and intent as 'sale'

        $payment = Paypalpayment::payment();

        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setTransactions(array($transaction));

        try {
            // ### Create Payment
            // Create a payment by posting to the APIService
            // using a valid ApiContext
            // The return object contains the status;
            $payment->create($this->_apiContext);
        } catch (\PPConnectionException $ex) {
            return  "Exception: " . $ex->getMessage() . PHP_EOL;
            exit(1);
        }

        dd($payment);
    } 

}