<?php

namespace App\Transformers;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;

abstract class BaseTransformer extends TransformerAbstract
{
    /**
     * @param array $response
     * @param array $data
     *
     * @return array
     */
    public function filterData(array $response, array $data): array
    {
        return array_merge($response, $data);
    }

    /**
     * prepare human readable time with users timezone.
     *
     * @param       $entity
     * @param       $responseData
     * @param array $columns
     * @param bool $isIncludeDefault
     *
     * @return array
     */
    public function addTimesHumanReadable(Model $entity, $responseData, array $columns = [], $isIncludeDefault = true): array
    {
        $auth = app('auth');
        if (! $auth->check()) {
            $responseData['create_at'] = isset($entity->created_at) ? $entity->created_at->toDateTimeString() : '';

            return $responseData;
        }
        $timeZone = $auth->user()->timezone ?? config('app.timezone');
        $readable = function ($column) use ($entity, $timeZone) {
            // sometime column is not carbonated, i mean instance if Carbon/Carbon
            $at = Carbon::parse($entity->{$column});

            return [
                $column => $at->format(config('settings.formats.datetime_12')),
                $column.'_readable' => $at->diffForHumans(),
                $column.'_tz' => $at->timezone($timeZone)->format(config('settings.formats.datetime_12')),
                $column.'_readable_tz' => $at->timezone($timeZone)->diffForHumans(),
            ];
        };
        $isHasCustom = count($columns) > 0;
        $defaults = ['created_at', 'updated_at', 'deleted_at'];
        // only custom
        if ($isHasCustom && ! $isIncludeDefault) {
            $toBeConvert = $columns;
        }  // custom and defaults
        elseif ($isHasCustom && $isIncludeDefault) {
            $toBeConvert = array_merge($columns, $defaults);
        } // only defaults
        else {
            $toBeConvert = $defaults;
        }
        $return = [];
        foreach ($toBeConvert as $column) {
            $return = array_merge($return,
                (! is_null($entity->{$column})) ? array_merge($return, $readable($column)) : []);
        }

        return array_merge($responseData, $return);
    }
}
