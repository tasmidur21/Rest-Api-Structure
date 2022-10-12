<?php

namespace App\Helpers\Classes;

use Illuminate\Database\Eloquent\Model;

class DatatableHelper
{
    public static function getActionButtonBlock(callable $callback): \Closure
    {
        return function (Model $model) use ($callback) {
            $hasAnyButton = false;
            $str = '';
            $str .= '<div class="btn-group-sm" role="group">';

            $callbackString = $callback($model);

            if ($callbackString) {
                $hasAnyButton = true;
                $str .= $callbackString;
            }
            $str .= '</div>';

            return $hasAnyButton ? $str : '<span />';
        };
    }

    public static function getActionButtonBlockDropDown(callable $callback): \Closure
    {
        return function (Model $model) use ($callback) {
            $hasAnyButton = false;
            $str = '';
            $str .= '<div class="dropdown">
                      <a class="btn btn-outline-danger dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        '.__("generic.action").'
                      </a>

                      <div class="dropdown-menu p-2"><div class="">';

            $callbackString = $callback($model);

            if ($callbackString) {
                $hasAnyButton = true;
                $str .= $callbackString;
            }
            $str .= '</div></div></div>';

            return $hasAnyButton ? $str : '<span />';
        };
    }
}
