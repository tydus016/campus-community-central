<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class Organizations extends Model
{
    protected $table = 'organizations';

    protected $fillable = [
        'organization_name',
        'organization_head',
        'organization_description',
        'organization_image',
        'read_flg' => 0,
        'created_at',
        'updated_at',
    ];

    public function create_organization(array $post)
    {
        $organization_name = $post['organization_name'] ?? null;
        $organization_head = $post['organization_head'] ?? '-';
        $organization_description = $post['organization_description'] ?? null;
        $organization_image = $post['organization_image'] ?? null;

        try {

            $validator = Validator::make($post, [
                'organization_name' => 'required',
            ]);

            if ($validator->fails()) {
                return [
                    'message' => $validator->errors()->first(),
                    'success' => false,
                ];
            }

            $insert_data = [
                'organization_name' => $organization_name,
                'organization_head' => $organization_head,
                'organization_description' => $organization_description,
                'organization_image' => $organization_image,
            ];

            $this->organization_name = $organization_name;
            $this->organization_head = $organization_head;
            $this->organization_description = $organization_description;
            $this->organization_image = $organization_image;
            $this->read_flg = 0;

            $this->save();

            $res = [
                'success' => true,
                'org_id' => $this->id,
                'message' => 'Organization created successfully',
            ];
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            $res = [
                'success' => false,
                'message' => 'Failed to create organization',
            ];
        }

        return $res;
    }
}
