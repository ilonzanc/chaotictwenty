<?php

/*
*
*   Global controller for the Admin plugin
*
*/
class AdminAppController extends AppController
{
    public function __construct()
    {
        // Include the models from AdminPlugin
        $models = Admin::getModels();
        foreach ($models as $model)
        {
            if (array_search($model->name, $this->models) === false)
            {
                $this->models[] = $model->name;
            }
        }

        // Parent construct after, otherwise models will not be loaded
        parent::__construct();
    }
}
