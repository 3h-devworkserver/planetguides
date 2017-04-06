<?php

namespace App\Http\Controllers\Backend\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\Pages\PageContract;
use App\Repositories\Backend\User\UserContract;
use Datatable;
use App\Models\Booking;
use App\Models\Review;
use App\Models\Contact;
use Illuminate\Http\Request;

class DataTableController extends Controller {

    /**
     * Abort if request is not ajax
     * @param Request $request
     */
    public function __construct(Request $request) {
        if (!$request->ajax() || !Datatable::shouldHandle())
            abort(403, 'Forbidden');
    }

    /**
     * JSON data for seeding Pages
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getPages(PageContract $pages) {

        return Datatable::collection($pages->getLimitPages())
                        ->showColumns('id', 'title')
                        ->addColumn('created_at', function($model) {
                            return "$model->created_at";
                        })
                        ->addColumn('updated_at', function($model) {
                            return "$model->updated_at";
                        })
                        ->addColumn('', function($model) {
                            return get_ops('pages', $model->id, $model->status);
                        })
                        ->searchColumns('title')
                        ->make();
    }

    /**
     * JSON data for seeding Deactivated Pages
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getDeactivatedPages(PageContract $pages) {

        return Datatable::collection($pages->getLimitPages('0'))
                        ->showColumns('id', 'title')
                        ->addColumn('created_at', function($model) {
                            return "$model->created_at";
                        })
                        ->addColumn('updated_at', function($model) {
                            return "$model->updated_at";
                        })
                        ->addColumn('', function($model) {
                            return get_ops('pages', $model->id, $model->status);
                        })
                        ->searchColumns('title')
                        ->make();
    }

    /**
     * JSON data for seeding Users
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getUsers(UserContract $users) {

        return Datatable::collection($users->getAllUsers())
                        ->showColumns('id')
                        ->addColumn('name', function($model) {
                            return $model->fname . ' ' . $model->lname;
                        })
                        ->showColumns('email')
                        ->showColumns('confirmed_label')
                        ->addColumn('roles', function($model) {
                            $data = '';
                            if ($model->roles()->count() > 0) {
                                foreach ($model->roles as $role) {
                                    $data .=$role->name . '<br/>';
                                }
                                return $data;
                            } else {
                                return 'None';
                            }
                        })
                        ->showColumns('certified_label')
                        ->addColumn('created_at', function($model) {
                            return "$model->created_at";
                        })
                        ->showColumns('action_buttons')
                        ->searchColumns('name', 'email')
                        ->orderColumns('name', 'roles')
                        ->make();
    }

    /**
     * JSON data for seeding Deactivated Users
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getDeactivatedUsers(UserContract $users) {

        return Datatable::collection($users->getAllUsers('0'))
                        ->showColumns('id')
                        ->addColumn('name', function($model) {
                            return $model->fname . ' ' . $model->lname;
                        })
                        ->showColumns('email')
                        ->showColumns('confirmed_label')
                        ->addColumn('roles', function($model) {
                            $data = '';
                            if ($model->roles()->count() > 0) {
                                foreach ($model->roles as $role) {
                                    $data .=$role->name . '<br/>';
                                }
                                return $data;
                            } else {
                                return 'None';
                            }
                        })
                        ->showColumns('certified_label')
                        ->addColumn('created_at', function($model) {
                            return "$model->created_at";
                        })
                        ->showColumns('action_buttons')
                        ->searchColumns('name', 'email')
                        ->orderColumns('name', 'roles')
                        ->make();
    }

    public function getGuides(UserContract $users) {

//var_dump('a'); die();
        return Datatable::collection($users->getUsers('1', '2'))
                        ->showColumns('id')
                        ->addColumn('name', function($model) {
                            return  ucfirst($model->fname) . ' ' . ucfirst($model->lname);
                        })
                        ->showColumns('email')
                        ->showColumns('guide_pts')
                        ->showColumns('confirmed_label')
                        ->addColumn('roles', function($model) {
                            $data = '';
                            if ($model->roles()->count() > 0) {
                                foreach ($model->roles as $role) {
                                    $data .=$role->name . '<br/>';
                                }
                                return $data;
                            } else {
                                return 'None';
                            }
                        })
                        ->showColumns('certified_label')
                        ->addColumn('created_at', function($model) {
                            return "$model->created_at";
                        })
                        ->showColumns('action_buttons')
                        ->searchColumns('name', 'email')
                        // ->orderColumns('id', 'id')                                            
                        ->make();
    }

    public function getTravellers(UserContract $users) {

        return Datatable::collection($users->getUsers('1', '3'))
                        ->showColumns('id')
                        ->showColumns('nickname')
                        ->addColumn('name', function($model) {
                           return  ucfirst($model->fname) . ' ' . ucfirst($model->lname);
                        })
                        ->showColumns('email')
                        ->showColumns('confirmed_label')
                        ->addColumn('roles', function($model) {
                            $data = '';
                            if ($model->roles()->count() > 0) {
                                foreach ($model->roles as $role) {
                                    $data .=$role->name . '<br/>';
                                }
                                return $data;
                            } else {
                                return 'None';
                            }
                        })
                        ->addColumn('certified_label', function() {
                            return 'No';
                        })
                        ->addColumn('created_at', function($model) {
                            return "$model->created_at";
                        })
                        ->showColumns('action_buttons')
                        ->searchColumns('name', 'email', 'nickname' )
                        // ->setCaseSensitive(false)
                        // ->orderColumns('name', 'roles')
                        // ->orderColumns('nickname')
                        ->make();
    }

    public function getLicense(UserContract $users) {
        return Datatable::collection($users->getLicense(0))
                        ->showColumns('id')
                        ->addColumn('name', function($model) {
                           return  ucfirst($model->fname) . ' ' . ucfirst($model->lname);
                        })
                        ->showColumns('email')
                        ->addColumn('license', function($model){
                            return $model->getAllLicense($model->id);
                        })
                         ->addColumn('created_at', function($model){
                           return \Carbon\Carbon::parse($model->created_at)->format('Y/m/d');
                            // return $model->created_at->diffForHumans();
                        })
                        ->addColumn('action_button', function($model) {
                            // return '<a href="' . route('backend.license', $model->id) . '">View</a>';
                            $url = url('admin/access/guide/'.$model->id.'/certify');
                            return '<a href="'.$url.'" class="btn btn-xs btn-success glyphicon glyphicon-ok" title="approve"></a>';
                        })
                        ->searchColumns('name', 'email','created_at' )
                        ->make();
    }

    public function getGuideReviews(UserContract $users) {

        return Datatable::collection($users->getGuideReviews(0))
                        ->showColumns('id')
                        ->showColumns('comment')
                        ->showColumns('approved_label')
                        ->addColumn('created_at', function($model) {
                            return "$model->created_at";
                        })
                        ->showColumns('action_buttons')
                        ->orderColumns('created_at')
                        ->make();
    }

    public function getAllReviews(UserContract $users) {
        // return Datatable::collection($users->getAllReviews())
        return Datatable::collection(Review::all())
                        // ->showColumns('nickname')
                        ->addColumn('nickname', function($model){
                            return $model->nickname($model->user_id);
                        })
                        ->showColumns('email')
                        ->showColumns('comment')
                        ->addColumn('approved', function($model) {
                            if ($model->approved == 1)
                                return "<label class='label label-success'>Approved</label>";
                            return "<label class='label label-danger'>Unapproved</label>";
                        })
                        ->addColumn('created', function($model) {
                            // return $model->created_at->diffForHumans();
                            return $model->date;
                        })
                        ->addColumn('action', function($model) {
                            return '<a href="' . route('admin.reviews.delete', $model->id) . '" class="btn btn-xs btn-danger fa fa-trash" onclick="return confirm(\'Are you sure want to delete?\')"></a>';
                        })
                         // ->searchColumns('nickname', 'email' )
                        ->make();
    }

    public function getAllSlides(UserContract $users) {
        return Datatable:: collection($users->getAllSlides())
                        ->showColumns('username')
                        ->addColumn('path', function($model) {
                            return '<div class="sm-slide-img"><img src="'. asset($model->path) .'" class="childprofile" alt="User Image" /></div>';
                        })
                        ->showColumns('caption')
                        ->showColumns('type')
                        ->addColumn('created', function($model) {
                            return "$model->created_at";
                        })
                        ->showColumns('action_buttons')
                        ->searchColumns('username', 'caption')
                        ->orderColumns('type', 'created_at')
                        ->make();
    }

    public function getAllGuideArea(UserContract $users) {
        return Datatable:: collection($users->getAllGuideArea())
                        ->showColumns('user_name')
                        ->showColumns('guide_area')
                        ->showColumns('ordering')
                        ->addColumn('created', function($model) {
                            return "$model->created_at";
                        })
                        ->showColumns('action_buttons')
                        ->searchColumns('user_name', 'guide_area')
                        // ->orderColumns('type', 'created_at')
                        ->make();
    }

    public function getAllLanguage(UserContract $users) {
        return Datatable:: collection($users->getAllLanguage())
                        ->showColumns('user_name')
                        ->showColumns('language')
                        ->showColumns('ordering')
                        ->addColumn('created', function($model) {
                            return "$model->created_at";
                        })
                        ->showColumns('action_buttons')
                        ->searchColumns('user_name', 'language')
                        // ->orderColumns('type', 'created_at')
                        ->make();
    }

    public function getUnapprovedReviews(UserContract $users) {
        // return Datatable::collection($users->getReviews(0))
        return Datatable::collection(Review::where('approved', 0)->get())
                        // aaaaa
                        ->addColumn('nickname', function($model){
                            return $model->nickname($model->user_id);
                        })
                        ->showColumns('email')
                        ->showColumns('comment')
                        ->addColumn('approved', function($model) {
                            if ($model->approved == 1)
                                return "<label class='label label-success'>Approved</label>";
                            return "<label class='label label-danger'>Unapproved</label>";
                        })
                        ->addColumn('created', function($model) {
                            // return $model->created_at->diffForHumans();
                            return $model->date;
                        })
                        ->addColumn('action', function($model) {
                            // return '<a href="' . route('admin.reviews.status', $model->id) . '">Approve</a>';
                             return '<a href="' . route('admin.reviews.status', $model->id) . '" class="btn btn-xs btn-success glyphicon glyphicon-ok"></a>';
                            
                         })
                         ->searchColumns('nickname', 'email' )
                        ->make();
    }

    public function getApprovedReviews(UserContract $users) {
        return Datatable::collection($users->getReviews(1))
                        ->showColumns('email')
                        ->showColumns('comment')
                        ->addColumn('approved', function($model) {
                            if ($model->approved == 1)
                                return "<label class='label label-success'>Approved</label>";
                            return "<label class='label label-danger'>Unapproved</label>";
                        })
                        ->addColumn('created', function($model) {
                            return "$model->created_at";
                        })
                        ->addColumn('action', function($model) {
                            return '<a href="' . route('admin.reviews', $model->id) . '">Approve</a>';
                        })
                        ->make();
    }

    public function getApprovedBookings(UserContract $users) {
        return Datatable::collection(Booking::getBookings(1))
                        ->showColumns('id')
                        ->addColumn('uid', function($model) {
                            if ($model->uid) {
                                $user_id = $model->uid;
                                $userdata = \DB::table('users')->select('fname', 'lname')->where('id', $user_id)->get();
                                $fullname = '';
                                foreach ($userdata as $rows) {
                                    $fullname = $rows->fname . ' ' . $rows->lname;
                                }

                                return $fullname;
                            } else {
                                return false;
                            }
                        })
                        ->addColumn('gid', function($model) {
                            if ($model->gid) {
                                $user_id = $model->gid;
                                $userdata = \DB::table('users')->select('fname', 'lname')->where('id', $user_id)->get();
                                $fullname = '';
                                foreach ($userdata as $rows) {
                                    $fullname = $rows->fname . ' ' . $rows->lname;
                                }

                                return $fullname;
                            } else {
                                return false;
                            }
                        })
                        ->addColumn('booked_for', function($model) {
                            return $model->first_name . ' ' . $model->last_name;
                        })
                        ->showColumns('transaction_id')
                        ->showColumns('amount')
                        ->showColumns('days')
                        ->showColumns('dates')
                        ->showColumns('status')
                        ->addColumn('created', function($model) {
                            return "$model->created_at";
                        })
                        ->addColumn('action', function($model){
                            return $model->availableActionButtons($model);
                        })
                        // ->showColumns('action_buttons')
                        ->searchColumns('first_name', 'last_name')
                        ->make();
    }

    public function getUnapprovedBookings(UserContract $users) {
        return Datatable::collection(Booking::getBookings(0))
                        ->showColumns('id')
                        ->addColumn('uid', function($model) {
                            if ($model->uid) {
                                $user_id = $model->uid;
                                $userdata = \DB::table('users')->select('fname', 'lname')->where('id', $user_id)->get();
                                $fullname = '';
                                foreach ($userdata as $rows) {
                                    $fullname = $rows->fname . ' ' . $rows->lname;
                                }

                                return $fullname;
                            } else {
                                return false;
                            }
                        })
                        ->addColumn('gid', function($model) {
                            if ($model->gid) {
                                $user_id = $model->gid;
                                $userdata = \DB::table('users')->select('fname', 'lname')->where('id', $user_id)->get();
                                $fullname = '';
                                foreach ($userdata as $rows) {
                                    $fullname = $rows->fname . ' ' . $rows->lname;
                                }

                                return $fullname;
                            } else {
                                return false;
                            }
                        })
                        ->addColumn('booked_for', function($model) {
                            return $model->first_name . ' ' . $model->last_name;
                        })
                        ->showColumns('transaction_id')
                        ->showColumns('amount')
                        ->showColumns('days')
                        ->showColumns('dates')
                        ->showColumns('status')
                        ->addColumn('created', function($model) {
                            return "$model->created_at";
                        })
                        ->showColumns('action_buttons')
                        ->searchColumns('first_name', 'last_name')
                        ->make();
    }

     public function getAllContactemail() {
        return Datatable::collection(Contact::all())
                        ->showColumns('id')
                        ->addColumn('name', function($model){
                            return ucfirst($model->name);
                        })
                        ->showColumns('email')
                        // ->showColumns('comment')
                        ->addColumn('comment', function($model) {
                            $length = strlen($model->comment);
                            if($length <= 600){
                                return '<div class="contactMsg"><p>' . $model->comment . '</p></div>'; 
                            }else{
                                return '<div class="contactMsg"><p class= "hide">' . $model->comment . '</p><p class="msg">' .substr($model->comment, 0, 600) . ' ..</p><p><a class="msgRead btn btn-xs btn-orange">read more</a></p></div>'; 
                            }
                        })
                        ->addColumn('created', function($model) {
                            return $model->convertDate($model->created_at); //need to change
                        })
                        ->addColumn('action', function($model) {
                            $link = url('admin/contactemail/'.$model->id.'/reply');
                            return '<a href="'.$link.'" class="btn btn-xs btn-info fa fa-reply"></a>';
                        })
                        ->searchColumns('name', 'email')
                        ->make();
    }



}
