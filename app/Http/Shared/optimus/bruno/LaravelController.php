<?php

namespace App\Http\Shared\Optimus\Bruno;

use JsonSerializable;
use InvalidArgumentException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Router;
use Illuminate\Http\JsonResponse;
use App\Http\Shared\Optimus\Architect\Architect;
use Illuminate\Http\Request;

abstract class LaravelController extends Controller
{
    /**
     * Defaults
     * @var array
     */
    protected $defaults = [];

    /**
     * Create a json response
     * @param  mixed  $data
     * @param  integer $statusCode
     * @param  array  $headers
     * @return Illuminate\Http\JsonResponse
     */
    protected function response($data, $statusCode = 200, array $headers = [])
    {
        if ($data instanceof Arrayable && !$data instanceof JsonSerializable) {
            $data = $data->toArray();
        }

        return new JsonResponse($data, $statusCode, $headers);
    }

    /**
     * Parse data using architect
     * @param  mixed $data
     * @param  array  $options
     * @param  string $key
     * @return mixed
     */
    protected function parseData($data, array $options, $key = null)
    {
        $architect = new Architect();

        return $architect->parseData($data, $options['modes'], $key);
    }

    /**
     * Page sort
     * @param array $sort
     * @return array
     */
    protected function parseSort(array $sort) {
        return array_map(function($sort) {
            if (!isset($sort['direction'])) {
                $sort['direction'] = 'asc';
            }

            return $sort;
        }, $sort);
    }

    /**
     * Parse include strings into resource and modes
     * @param  array  $includes
     * @return array The parsed resources and their respective modes
     */
    protected function parseIncludes(array $includes)
    {
        $return = [
            'includes' => [],
            'modes' => []
        ];

        foreach ($includes as $include) {
            $explode = explode(':', $include);

            if (!isset($explode[1])) {
                $explode[1] = $this->defaults['mode'];
            }

            $return['includes'][] = $explode[0];
            $return['modes'][$explode[0]] = $explode[1];
        }

        return $return;
    }

    /**
     * Parse filter group strings into filters
     * Filters are formatted as key:operator(value)
     * Example: name:eq(esben)
     * @param  array  $filter_groups
     * @return array
     */
    protected function parseFilterGroups(array $filter_groups)
    {
        $return = [];

        foreach($filter_groups as $group) {
            if (!array_key_exists('filters', $group)) {
                throw new InvalidArgumentException('Filter group does not have the \'filters\' key.');
            }

            $filters = array_map(function($filter){
                if (!isset($filter['not'])) {
                    $filter['not'] = false;
                }

                return $filter;
            }, $group['filters']);

            $return[] = [
                'filters' => $filters,
                'or' => isset($group['or']) ? $group['or'] : false
            ];
        }

        return $return;
    }

    /**
     * Parse GET parameters into resource options
     * @return array
     */
    protected function parseResourceOptions($request = null)
    {
        if ($request === null) {
            $request = request();
        }

        $this->defaults = array_merge([
            'includes' => [],
            'sort' => [],
            'limit' => null,
            'page' => null,
            'mode' => 'embed',
            'filter_groups' => [],
            'paginate' => null
        ], $this->defaults);

        $includes = $this->parseIncludes($request->json()->get('includes', $this->defaults['includes']));
        $sort = $this->parseSort($request->json()->get('sort', $this->defaults['sort']));
        $limit = $request->get('limit', $this->defaults['limit']);
        $page = $request->get('page', $this->defaults['page']);
        $paginate = $request->get('paginate', $this->defaults['paginate']);
        $filter_groups = $this->parseFilterGroups($request->json()->get('filter_groups', $this->defaults['filter_groups']));

        if ($page !== null && ($limit === null && $paginate === null)) {
            throw new InvalidArgumentException('Cannot use page option without limit option');
        }

        return [
            'includes' => $includes['includes'],
            'modes' => $includes['modes'],
            'sort' => $sort,
            'limit' => $limit,
            'page' => $page,
            'paginate' => $paginate,
            'filter_groups' => $filter_groups
        ];
    }


    protected function parseArrayOptions($options = null)
    {
        if ($options === null) {
            $options = [
                'includes' => [],
                'sort' => [],
                'limit' => null,
                'page' => null,
                'mode' => 'embed',
                'filter_groups' => [],
                'paginate' => null
            ];
        }

        $this->defaults = array_merge([
            'includes' => [],
            'sort' => [],
            'limit' => null,
            'page' => null,
            'mode' => 'embed',
            'filter_groups' => [],
            'paginate' => null
        ], $this->defaults);

        $includes = $this->parseIncludes(isset($options['includes']) ? $options['includes'] : $this->defaults['includes']);
        $sort = $this->parseSort(isset($options['sort']) ? $options['sort'] : $this->defaults['sort']);
        $limit = isset($options['limit']) ? $options['limit'] : $this->defaults['limit'];
        $page = isset($options['page']) ? $options['page'] : $this->defaults['page'];
        $paginate = isset($options['paginate']) ? $options['paginate'] : $this->defaults['paginate'];
        $filter_groups = $this->parseFilterGroups(isset($options['filter_groups']) ? $options['filter_groups'] : $this->defaults['filter_groups']);

        if ($page !== null && ($limit === null && $paginate === null)) {
            throw new InvalidArgumentException('Cannot use page option without limit option');
        }

        return [
            'includes' => $includes['includes'],
            'modes' => $includes['modes'],
            'sort' => $sort,
            'limit' => $limit,
            'page' => $page,
            'paginate' => $paginate,
            'filter_groups' => $filter_groups
        ];
    }
}
