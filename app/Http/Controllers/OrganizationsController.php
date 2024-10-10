<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Organizations;
use Illuminate\Support\Facades\Log;

class OrganizationsController extends Controller
{
    public function org_profile_view($org_id = null)
    {
        return Inertia::render('Organization/Profile', [
            'org_id' => $org_id,
        ]);
    }

    public function post_details_view()
    {
        return Inertia::render('Organization/PostDetails');
    }

    // - end of views

    public function organizations_lists(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();

            $result = (new Organizations())->organizations_lists($post);
            if (isset($result['success']) && $result['success']) {
                $res = [
                    'data' => $result['data'],
                    'has_next' => $result['has_next'],
                    'count' => $result['count'],
                    'total_count' => $result['total_count'],
                    'status' => true
                ];
            } else {
                $res = [
                    'message' => $result['message'],
                    'status' => $result['success'],
                ];
            }
        } catch (\Exception $e) {
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
}
