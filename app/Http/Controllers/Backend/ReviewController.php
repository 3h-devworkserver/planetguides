<?php namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Kris\LaravelFormBuilder\FormBuilder;
use Laracasts\Flash\Flash;
use Datatable;
use App\Models\Review;
use App\Models\Guide;

class ReviewController extends Controller
{

/**
	*@return mixed
	*/
	public function getUnapprovedReviews(){

		$table = $this->setDatatableReview(0); //0 is for unapproved reviews
		return view('backend.unapprovedReviews', compact('table'));
	}

	public function getAllReviews()
	{
		$table = $this ->setDatatableReviewAll();
		return view('backend.reviews', compact('table'));
	}

    public function changeStatusReviews($id)
    {
        $review = Review::find($id);
        $review->approved= 1;
        if($review->save()){
            $guide = Guide::where('gid', $review->guide_id )->first();
            $guide->recalculateRating();
            return redirect()->to('admin/reviews/unapproved')->withFlashSuccess('Successfully review approved.');
        }
        return redirect()->to('admin/reviews/unapproved')->withFlashDanger('Error during approve process');
    }

    public function deleteReview($id){
        $review = Review::find($id);
        if($review->delete())
            return redirect()->to('admin/reviews/all')->withFlashSuccess('Successfully deleted reviews.');
    }

	/**
     * Create DataTable HTML
     *
     * @return mixed
     * @throws \Exception
     */
    private function setDatatableReview($status)
    {
        $route = route('api.table.reviews.approved');
        if ($status==0) {
           $route = route('api.table.reviews.unapproved');
        }
        
        return Datatable::table()
            ->addColumn('Nickname', 'Email','Review','Status','Review Date','Action')
            ->setUrl($route)
            ->setOrder(['4'=>'desc', '0'=>'asc'])
            ->render();
    }

        /**
     * Create DataTable HTML
     *
     * @return mixed
     * @throws \Exception
     */
    private function setDatatableReviewAll()
    {
        $route = route('api.table.reviews.all');
        return Datatable::table()
            ->addColumn('Nickname', 'Email','Review','Status','Review Date','Action')
            ->setUrl($route)
            ->setOrder(['4'=>'desc', '0'=>'asc'])
            ->render();
    }
}