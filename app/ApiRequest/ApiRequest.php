<?php

namespace App\ApiRequest;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Http\Request;

abstract class ApiRequest
{
    // Should be query params from request
    protected $filters;
    protected $searchKeyword;
    protected $perPage;
    protected $page;
    protected $sortingParams;

    // Builder instance
    protected Builder $builder;

    public function __construct(Request $request)
    {
        $this->_parseRequest($request);
    }

    private function _parseRequest(Request $request)
    {
        $this->filters = $request->except(['search', 'per_page', 'current_page', 'sort']);
        $this->searchKeyword = $request->search;
        $this->perPage = $request->per_page;
        $this->page = $request->current_page;
        $this->sortingParams  = $request->sort;
    }

    public function paginate(Builder $builder, $perPage, $currentPage)
    {
        if (!isset($perPage) || !isset($currentPage)) {
            abort(422, "Les informations pour la pagination sont incompletes. Verifiez votre url");
        }

        return $builder->simplePaginate($perPage, ['*'], 'page', $currentPage)->withQueryString();
    }



    public function filter($filters)
    {
        foreach ($filters as $name => $value) {
            if (method_exists($this, $name)) {
                $params = $this->serialiseFilteringParams($value);
                call_user_func_array([$this, $name], [$params['value'], $params['operator']]);
            } else {
                abort(422, "Le filtre '" . $name . "' n'existe pas. Verifiez votre url");
            }
        }
    }

    private function serialiseFilteringParams($filteringValue)
    {
        $firstCharacter = substr($filteringValue, 0, 1);

        return ['value' => $this->serialiseParams($filteringValue), 'operator' => in_array($firstCharacter, ['<', '>']) ? $firstCharacter : '='];
    }


    public function research($keyword)
    {
        if (method_exists($this, 'search')) {
            call_user_func_array([$this, 'search'], [$keyword]);
        } else {
            abort(422, "La recherche n'est pas configuré pour cet endpoit. Verifiez votre url");
        }
    }


    public function sort($sortingParams)
    {
        $elements = explode(',', $sortingParams);
        foreach ($elements as $element) {
            $sortingDirection = $this->getSortingDirection($element);
            $element = $this->serialiseParams($element);
            // if (property_exists($this, $this->serialiseSortingParams($element))) {
            $this->builder->orderBy($element,   $sortingDirection);
            // } else {
            //     abort(422, "L'endpoint ne peut pas être trié avec le champs '" . $this->serialiseSortingParams($element) . "' .Verifiez votre url");
            // }
        }
    }

    private function getSortingDirection($sortingParam): string
    {
        return str_starts_with($sortingParam, '-') ? 'desc' : 'asc';
    }

    private function serialiseParams($sortingParam): string
    {
        if (str_starts_with($sortingParam, '+') || str_starts_with($sortingParam, '-')) {
            $sortingParam = substr($sortingParam, 1);
        }

        return trim($sortingParam);
    }



    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        $this->research($this->searchKeyword);

        $this->filter($this->filters);

        if ($this->sortingParams) $this->sort($this->sortingParams);

        return isset($this->perPage) || isset($this->page) ?  $this->paginate($builder, $this->perPage, $this->page) : $builder->get();
    }
}
