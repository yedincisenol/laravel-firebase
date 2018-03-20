<?php
/**
 * Created by PhpStorm.
 * User: yedincisenol
 * Date: 12.12.2017
 * Time: 10:59
 */

namespace yedincisenol\LaravelFirebase;

use Firebase;

trait FirebaseSync
{

    /**
     * Path of firebase save data
     * @var
     */
    protected $firebasePath;

    /**
     * Data fields for sync firebase
     * @var
     */
    protected $firebaseFields;

    public static function bootFirebaseSync()
    {
        static::created(function ($model) {
            $model->saveFirebase();
        });

        static::updated(function ($model) {
            $model->saveFirebase();
        });

        static::deleted(function ($model) {
            $model->deleteFirebase();
        });

    }

    public function saveFirebase()
    {
        return Firebase::set($this->getFirebasePath(), $this->getFirebaseRecord());
    }

    protected function getFirebasePath()
    {
        if ($this->firebasePath) {
            return $this->firebasePath;
        }

        return $this->getTable();
    }

    protected function getFirebaseFields()
    {
        if ($this->firebaseFields) {
            return $this->firebaseFields;
        }

        return $this->getFillable();
    }

    protected function getFirebaseRecord()
    {
        $record = [];
        foreach ($this->getFirebaseFields() as $field) {
            $record[$field] = $this->$field;
        }

        return $record;
    }

    public function deleteFirebase()
    {
        return Firebase::delete($this->getFirebasePath());
    }

}