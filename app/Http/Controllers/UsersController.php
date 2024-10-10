<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use App\Models\Users;
use App\Models\PasswordResetTokens;
use App\Models\Organizations;

class UsersController extends Controller
{

    public function user_profile_view()
    {
        return Inertia::render('Users/Profile');
    }

    public function users_lists_view()
    {
        return Inertia::render('Users/Lists');
    }

    public function users_details_view($id)
    {
        return Inertia::render('Users/Details', [
            'user_id' => $id,
        ]);
    }

    public function new_user_view()
    {
        return Inertia::render('Users/NewUser');
    }

    // - end of views - //

    public function create_user(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();
            $post['account_type'] = ACCOUNT_TYPE_USER;

            $result = (new Users())->create_user($post);
            if (isset($result['success']) && $result['success']) {
                $this->commit_transact();
            }

            $res = [
                'message' => $result['message'],
                'status' => $result['success'],
            ];
        } catch (Exception $e) {
            $this->rollback_transact();

            $res = [
                'message' => $e->getMessage(),
                'status' => false,
            ];
        } finally {
            $this->end_transact();
        }

        return $this->_response($res);
    }

    public function security_questions(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();
            $childhood_nickname = $post['childhood_nickname'];
            $bestfriend_name = $post['bestfriend_name'];
            $first_pet_name = $post['first_pet_name'];

            $result = (new Users())->get_user_details($post);

            if (isset($result['success']) && $result['success']) {
                $data = $result['data'];

                if (
                    $data->childhood_nickname == $childhood_nickname &&
                    $data->bestfriend_name == $bestfriend_name &&
                    $data->first_pet_name == $first_pet_name
                ) {

                    $resetToken = (new PasswordResetTokens())->create_token($data->id);

                    if (isset($resetToken['success']) && $resetToken['success']) {
                        $res = [
                            'message' => 'Security questions are correct.',
                            'redirect' => 'new-password/' . $resetToken['token'],
                            'status' => true,
                        ];

                        $this->commit_transact();
                    } else {
                        $res = [
                            'message' => $resetToken['message'],
                            'status' => $resetToken['success'],
                        ];
                    }
                } else {
                    $res = [
                        'message' => 'Security questions are incorrect.',
                        'status' => false,
                    ];
                }
            } else {
                $res = [
                    'message' => $result['message'],
                    'status' => $result['success'],
                ];
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());

            $res = [
                'message' => $e->getMessage(),
                'status' => false,
            ];
        } finally {
            $this->end_transact();
        }

        return $this->_response($res);
    }

    public function change_password(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();

            $result = (new Users())->update_password($post);

            if (isset($result['success']) && $result['success']) {

                PasswordResetTokens::where('user_id', $post['user_id'])->delete();

                $this->commit_transact();
            }

            $res = [
                'message' => $result['message'],
                'status' => $result['success'],
            ];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $this->rollback_transact();

            $res = [
                'message' => $e->getMessage(),
                'status' => false,
            ];
        } finally {
            $this->end_transact();
        }

        return $this->_response($res);
    }

    public function create_admin_account(Request $request)
    {
        $res = [];

        try {
            $this->start_transact();

            $post = $request->all();
            $post['account_type'] = ACCOUNT_TYPE_ADMIN;

            $fileUpload = $this->upload($request, 'organization_image');
            if (isset($fileUpload['success']) && $fileUpload['success']) {

                $post['organization_image'] = $fileUpload['file_path'];
                $result = (new Organizations())->create_organization($post);

                if (isset($result['success']) && $result['success']) {
                    $post['organization_id'] = $result['org_id'];

                    $createUser = (new Users())->create_user($post);

                    if ($createUser['success']) {
                        $this->commit_transact();

                        $res = [
                            'message' => 'Organization Account Created Successfully',
                            'status' => $result['success'],
                        ];
                    } else {
                        $this->rollback_transact();

                        $res = [
                            'message' => $createUser['message'],
                            'status' => $createUser['success'],
                        ];
                    }
                } else {
                    $res = [
                        'message' => $result['message'],
                        'status' => $result['success'],
                    ];
                }
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $this->rollback_transact();

            $res = [
                'message' => $e->getMessage(),
                'status' => false,
            ];
        } finally {
            $this->end_transact();
        }

        return $this->_response($res);
    }
}
