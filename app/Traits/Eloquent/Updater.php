<?php

namespace App\Traits\Eloquent;

trait Updater
{
    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            $user = \Auth::user();
            // $model->created_by = $user->id;
            // $model->updated_by = $user->id;
        });

        static::updating(function($model)
        {
           $user = \Auth::user();
            // $model->updated_by = $user->id;
        });
		/*
         * Deleting a model is slightly different than creating or deleting. For
         * deletes we need to save the model first with the deleted_by field
         * */
        static::deleting(function($model)
        {
			foreach ($model->relationMethods as $relationMethod)
            {
				if ($model->$relationMethod()->count() > 0)
                {
					return false;
				}
			}
            $model->row_status = 0;
            $model->save();
        });
    }
}
