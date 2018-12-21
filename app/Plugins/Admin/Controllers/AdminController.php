<?php

class AdminController extends AppController
{
    public $plugin = 'Admin';
    public $models = array('Administrator');

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

        include_once('Plugins/Admin/Views/Helpers/AdminMenu.php');
        $this->View->AdminMenu = new AdminMenu();

        include_once('Plugins/Admin/Views/Helpers/Field.php');
        $this->View->Field = new FieldHelper();

        // Set the current table (for the menu)
        $currentTable = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
        $currentTable = substr($_SERVER['REQUEST_URI'], strlen($currentTable));
        $currentTable = substr($currentTable, 6);
        if (strpos($currentTable, '?') > -1) {
            $currentTable = substr($currentTable, 0, strpos($currentTable, '?'));
        }
        if (strpos($currentTable, '/') > -1) {
            $currentTable = substr($currentTable, 0, strpos($currentTable, '/'));
        }

        $this->View->set(array(
            'currentTable' => $currentTable,
        ));
    }

    /**
    *   Login
    */
    public function login()
    {
        if (count($_POST) > 0)
        {
            $admin = $this->Administrator->find(
                array(
                    'limit' => 1,
                    'where' => array(
                        array('username', '=', $_POST['username']),
                        array('password', '=', $_POST['password']),
                    )
                )
            );

            if ($admin)
            {
                $_SESSION['DTWENTY'] = array(
                    'user_id' => $admin['id'],
                    'user_name' => $admin['username'],
                    'user_email' => $admin['email']
                );

                $this->redirect('/admin');
            }
            else
            {
                $this->View->set(array('errors' => array('Login failed, try again')));
                $this->View->render('Dashboard/login', 'Admin');
            }
        }
        else
        {
            $this->View->render('Dashboard/login', 'Admin');
        }
    }

    /**
    *   Logout
    */
    public function logout()
    {
        session_unset();
        $this->redirect('/admin/login');
    }

    /**
    *   Dashboard
    */
    public function dashboard()
    {
        $this->View->render('Dashboard/index', 'Admin');
    }

    /**
    *   Overview of a table
    */
    public function overview($tablename)
    {
        $model = $this->_getModel($tablename);
        $select = ((isset($model->overviewFields)) ? $model->overviewFields : '*');
        $data = $model->find(array(
            'select' => $select,
            'orderBy' => ((isset($_GET['sort'])) ? $_GET['sort'] : 'id') . ' ' . ((isset($_GET['order'])) ? $_GET['order'] : 'asc'),
            'env' => 'Admin'
        ));

        for ($i = 0; $i < count($data); $i++)
        {
            foreach ($data[$i] as $key => $value)
            {
                if (strpos($key, '_id'))
                {
                    // Has One
                    $a = array_column($model->relations['hasOne'], 'foreignKey');
                    $b = array_keys($model->relations['hasOne']);
                    $c = array_combine($b, $a);
                    $relation = array_search($key, $c);
                    if ($relation != null)
                    {
                        $data[$i][$key] = $data[$i][$relation];
                        unset($data[$i][$relation]);
                    }
                }
            }
        }

        $this->View->set(array(
            'model' => $model,
            'data' => $data
        ));

        $this->View->render('Data/overview', 'Admin');
    }

    /**
    *   Single view of an item
    */
    public function single($tablename, $id)
    {
        $model = $this->_getModel($tablename);

        $this->View->set(array(
            'model' => $model,
            'data' => $model->find(
                array(
                    'limit' => 1,
                    'where' => array(['id', '=', $id])
                )
            )
        ));

        $this->View->render('Data/single', 'Admin');
    }

    /**
    *   Edit view of an item
    */
    public function edit($tablename, $id)
    {
        $model = $this->_getModel($tablename);

        if (count($_POST) > 0)
        {
            $data = array();

            if (count($_FILES) > 0) {
                foreach ($_FILES as $key => $file) {
                    $_uploaded = $this->_uploadFile($file);
                    if ($_uploaded) $_POST[$key] = $_uploaded;
                }
            }

            $data = $this->_parseSpecialFields($_POST, $model);

            $this->{$model->name}->edit($id, $data);
            $this->redirect('/admin/' . $tablename);
        }
        else
        {
            $this->View->set(array(
                'model' => $model,
                'data' => $model->find(
                    array(
                        'limit' => 1,
                        'where' => array(['id', '=', $id])
                    )
                )
            ));

            $this->View->render('Data/edit', 'Admin');
        }
    }

    /**
    *   Creation page of a table
    */
    public function create($tablename)
    {
        $model = $this->_getModel($tablename);

        if (count($_POST) > 0)
        {
            if (count($_FILES) > 0) {
                foreach ($_FILES as $key => $file) {
                    $_uploaded = $this->_uploadFile($file);
                    if ($_uploaded) $_POST[$key] = $_uploaded;
                }
            }

            $data = $this->_parseSpecialFields($_POST, $model);

            $_item = $this->{$model->name}->create($data);
            $this->redirect('/admin/' . $tablename . '/' . $_item);
        }
        else
        {
            $this->View->set(array('model' => $model));
            $this->View->render('Data/create', 'Admin');
        }
    }

    /**
    *   Delete a model (after confirmation)
    */
    public function delete($tablename, $id)
    {
        $model = $this->_getModel($tablename);

        if (isset($_GET['confirm']) && $_GET['confirm'] == '1')
        {
            $this->{$model->name}->delete($id);
            $this->redirect('/admin/' . $tablename);
        }
        else
        {
            $this->View->set(array(
                'model' => $model,
                'data' => $model->find(
                    array(
                        'limit' => 1,
                        'where' => array(['id', '=', $id])
                    )
                )
            ));

            $this->View->render('Data/delete', 'Admin');
        }
    }

    /**
    *   Get a model that's loaded into the plugin
    *   @var Model
    */
    protected function _getModel($tablename)
    {
        $_models = Admin::getModels();
        foreach ($_models as $item)
        {
            if ($item->tablename == $tablename)
            {
                if (isset($_models[$item->name]))
                    $model = $_models[$item->name];

                if (isset($modelAdmin) && class_exists($modelAdmin->name))
                {
                    return $modelAdmin;
                }
                else if (isset($model) && class_exists($model->name))
                {
                    return $model;
                }

                break;
            }
        }
        throw new D20Exception('Model for ' . $tablename . ' not found');
    }

    /**
    *   Upload images and thumbs
    *   @param $_FILES
    *   @return string
    */
    protected function _uploadFile($file)
    {
        $targetdir = 'webroot/img/uploads/';
        $targetdirThumb = 'webroot/img/uploads/thumbs/';
        $extension = '.' . explode('/', $file["type"])[1];
        $filename = md5(date("l jS \of F Y h:i:s A")) . $extension;
        $targetfile = $targetdir . $filename;
        $targetfileThumb = $targetdirThumb . $filename;

        if ($file['tmp_name'] != '')
        {
            if (!move_uploaded_file($file['tmp_name'], $targetfile))
            {
                // TODO error message
            }

            // TODO thumb
            if (!copy($targetfile, $targetfileThumb))
            {
                // TODO error message
            }
        }
        else
        {
            return false;
        }

        return $filename;
    }

    /**
    *   Parse special fields defined in the model
    *   @param $_POST
    *   @return array
    */
    private function _parseSpecialFields($post, $model)
    {
        $data = array();

        foreach ($post as $key => $value)
        {
            // Check special fields
            if ($model->adminFields)
            {
                foreach ($model->adminFields as $adminKey => $adminValue)
                {
                    if ($adminKey == $key)
                    {
                        if ($adminValue['type'] == 'Checkbox')
                        {
                            $value = (($value == 'on') ? 1 : 0);
                        }
                    }
                }
            }

            $data[$key] = $value;
        }

        return $data;
    }
}
