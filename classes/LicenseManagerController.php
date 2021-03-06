<?php

namespace Grav\Plugin\LicenseManager;

use Grav\Common\Grav;

/**
 * Class Controller
 * @package Grav\Plugin\LicenseManager
 */
class LicenseManagerController
{
    protected $controller;
    protected $method;
    protected $post;

    /**
     * LicenseManagerController constructor.
     *
     * @param $controller
     * @param $method
     */
    public function __construct($controller, $method)
    {
        $this->controller = $controller;
        $this->post = $controller->data;
        $this->method = $method;
        $this->admin = Grav::instance()['admin'];
    }

    /**
     * Generic Execute function
     *
     * @return bool|mixed
     */
    public function execute()
    {
        $success = false;
        if (method_exists($this, $this->method)) {
            try {
                $success = call_user_func([$this, $this->method]);
            } catch (\RuntimeException $e) {
                $success = true;
                $this->admin->setMessage($e->getMessage(), 'error');
            }
        }
        return $success;
    }

    /**
     * Save License task
     *
     * @return bool
     */
    public function taskSaveLicenses() {

        $obj = LicenseManager::load();
        $obj->merge($this->post);

        try {
            $obj->validate();
        } catch (\Exception $e) {
            $this->admin->setMessage($e->getMessage(), 'error');
            return false;
        }

        $obj->filter();
        $obj->save();

        $this->admin->setMessage($this->admin->translate('PLUGIN_ADMIN.SUCCESSFULLY_SAVED'), 'info');
    }
}