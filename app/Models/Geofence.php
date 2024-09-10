<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class Geofence extends Model
{
    protected $table = 'geofence';

    protected $fillable = [
        'coordinates',
        'description',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function create_fence($post)
    {
        $coordinates = isset($post['coordinates']) ? $post['coordinates'] : [];
        $description = isset($post['description']) ? $post['description'] : GEOFENCE_DEFAULT_DESCRIPTION;
        $status = isset($post['status']) ? $post['status'] : GEOFENCE_STATUS_ACTIVE;

        $current_date = date('Y-m-d H:i:s');

        try {
            $validator = Validator::make($post, [
                'coordinates' => 'required|string',
            ]);

            if ($validator->fails()) {
                return [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ];
            }

            $insert_data  = [
                'coordinates' => $coordinates,
                'description' => $description,
                'status' => $status,
                'created_at' => $current_date,
            ];

            $insert = self::create($insert_data);

            $res = [
                'success' => true,
                'message' => 'Geofence successfully created',
                'data' => $insert,
            ];
        } catch (QueryException $e) {
            $res = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        return $res;
    }

    public function get_active_fence()
    {
        try {
            $result = self::where('status', GEOFENCE_STATUS_ACTIVE)->orderBy('id', 'desc')->first();

            if ($result) {
                $res = [
                    'success' => true,
                    'data' => $result,
                ];
            } else {
                $res = [
                    'success' => false,
                    'message' => 'No active geofence found',
                ];
            }
        } catch (QueryException $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        return $res;
    }

    public function is_inside_fence(array $post)
    {
        $geo_point = isset($post['geo_point']) ? $post['geo_point'] : [];
        $lat_point = isset($post['lat']) ? $post['lat'] : $geo_point['lat'];
        $lng_point = isset($post['lng']) ? $post['lng'] : $geo_point['lng'];

        try {
            $active_fence = $this->get_active_fence();
            if (isset($active_fence['success']) && $active_fence['success']) {
                $data = $active_fence['data'];
                $coordinates = $data->coordinates;

                $params = ['lat' => $lat_point, 'lng' => $lng_point];
                $inside = $this->isPointInPolygon($params, $coordinates);

                $res = [
                    'success' => true,
                    'inside' => $inside,
                ];
            } else {
                $res = [
                    'success' => false,
                    'message' => $active_fence['message'],
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        return $res;
    }

    private function isPointInPolygon($post, $polygon)
    {
        $x = $post['lat'];
        $y = $post['lng'];
        $inside = false;
        $n = count($polygon);

        for ($i = 0, $j = $n - 1; $i < $n; $j = $i++) {
            $xi = $polygon[$i]['lat'];
            $yi = $polygon[$i]['lng'];
            $xj = $polygon[$j]['lat'];
            $yj = $polygon[$j]['lng'];

            $intersect = (($yi > $y) != ($yj > $y)) &&
                ($x < ($xj - $xi) * ($y - $yi) / ($yj - $yi) + $xi);
            if ($intersect) {
                $inside = !$inside;
            }
        }

        return $inside;
    }

    public function get_fences_lists(array $post)
    {
        $fence_id = isset($post['fence_id']) ? $post['fence_id'] : null;
        $description = isset($post['description']) ? $post['description'] : null;
        $status = isset($post['status']) ? $post['status'] : null;
        $from_date = isset($post['from_date']) ? $post['from_date'] : null;
        $to_date = isset($post['to_date']) ? $post['to_date'] : null;

        $page = isset($post['page']) ? $post['page'] : 1;
        $limit = isset($post['limit']) ? $post['limit'] : 10;
        $offset = ($page - 1) * $limit;

        try {
            $query = self::query();

            if ($fence_id) {
                $query->where('id', $fence_id);
            }

            if ($description) {
                $query->where('description', 'like', '%' . $description . '%');
            }

            if ($status) {
                $query->where('status', $status);
            }

            if ($from_date && $to_date) {
                $query->whereBetween('created_at', [$from_date, $to_date]);
            }

            $total_count = $query->count();

            $result = $query->orderBy('created_at', 'desc')
                ->offset($offset)
                ->limit($limit)
                ->get();

            if ($result) {
                foreach ($result as &$value) {
                    $value->coordinates = json_decode($value->coordinates, true);
                }

                $result = format_result($result);
            }

            $total_pages = ceil($total_count / $limit);
            $has_next = ($total_count > ($page * $limit));

            $res = [
                'success' => true,
                'count' => $total_count,
                'total_pages' => $total_pages,
                'has_next' => $has_next,
                'data' => $result,
            ];
        } catch (QueryException $e) {
            $res = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        return $res;
    }
}
