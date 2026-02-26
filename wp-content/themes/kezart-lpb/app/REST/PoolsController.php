<?php

declare(strict_types=1);

namespace RS\Theme\App\REST;

use WP_Query;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;

readonly class PoolsController
{
    public function __construct(
        public string $namespace,
        private string $base = '/pools'
    ) {
    }

    public function registerRoutes(): void
    {
        register_rest_route(
            $this->namespace,
            $this->base,
            [
                [
                    'methods' => WP_REST_Server::READABLE,
                    'callback' => [$this, 'getItems'],
                    'args' => [
                        'city' => ['type' => 'string'],
                        'course_type' => ['type' => 'integer'],
                        'order_by' => ['type' => 'string'],
                    ],
                    'permission_callback' => '__return_true',
                ],
            ]
        );
    }

    public function getItems(WP_REST_Request $request): WP_REST_Response
    {
        $params = $request->get_params();

        $city = !empty($params['city']) ? sanitize_text_field($params['city']) : null;
        $courseType = !empty($params['course_type']) ? absint($params['course_type']) : null;
        $orderBy = !empty($params['order_by']) ? sanitize_text_field($params['order_by']) : null;

        $poolsArgs = [
            'post_type' => 'pool',
            'posts_per_page' => -1,
        ];

        if (!empty($orderBy)) {
            $poolsArgs['orderby'] = 'title';
            $poolsArgs['order'] = strtoupper($orderBy);
        }

        $pools = new WP_Query($poolsArgs);
        if (!$pools->have_posts()) {
            wp_reset_postdata();
            return new WP_REST_Response([], 404);
        }

        $allPools = [];
        while ($pools->have_posts()) : $pools->the_post();
            $address = get_field('pool_location', get_the_ID());

            $allPools[] = [
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'location' => [
                    'name' => $address['name'],
                    'post_code' => $address['post_code'],
                    'city' => $address['city'],
                    'lat' => $address['lat'],
                    'lng' => $address['lng'],
                ],
                'url' => get_permalink(),
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'medium'),
            ];
        endwhile;
        wp_reset_postdata();

        // Filter by city.
        if (!empty($city)) {
            $allPools = array_values(array_filter($allPools, function ($pool) use ($city) {
                return $pool['location']['city'] === $city;
            }));
        }

        if (!empty($courseType)) {
            $poolsForCourse = get_field('course_pools', $courseType);
            $allPools = array_values(array_filter($allPools, function ($pool) use ($poolsForCourse) {
                return in_array($pool['id'], $poolsForCourse);
            }));
        }

        if (empty($allPools)) {
            return new WP_REST_Response([], 404);
        }

        return new WP_REST_Response($allPools, 200);
    }
}
