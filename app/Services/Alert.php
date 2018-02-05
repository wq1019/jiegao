<?php

namespace App\Services;

use Illuminate\Contracts\Session\Session;

class Alert
{
    const ALERT_KEY = 'ALERT_FLASH';

    /**
     * @var Session
     */
    private $session;

    private $config;

    private $isCurrentSession = false;

    public function __construct(Session $session, $config)
    {
        $this->session = $session;
        $this->config = $config;
    }

    public function hasMessage()
    {
        return $this->session->has(static::ALERT_KEY);
    }

    public function keepMessage()
    {
        $this->session->keep(static::ALERT_KEY);
    }

    public function setInfo($message)
    {
        $this->setMessage('info', $message);
    }

    public function setMessage($type, $message, $hasCloseButton = null, $needContainer = null)
    {
        if (!in_array($type, $this->config['allow_type_list'])) {
            $type = $this->config['default_type'];
        }
        if (is_null($hasCloseButton)) {
            $hasCloseButton = $this->config['default_has_button'];
        }
        if (is_null($needContainer)) {
            $needContainer = $this->config['default_need_container'];
        }
        $this->isCurrentSession = true;
        $this->session->flash(
            static::ALERT_KEY, [
                'type'           => $type,
                'message'        => $message,
                'hasCloseButton' => (bool) $hasCloseButton,
                'needContainer'  => (bool) $needContainer,
            ]
        );
    }

    public function setSuccess($message)
    {
        $this->setMessage('success', $message);
    }

    public function setWarning($message)
    {
        $this->setMessage('warning', $message);
    }

    public function setDanger($message)
    {
        $this->setMessage('danger', $message);
    }

    public function getMessage()
    {
        if ($this->session->has(static::ALERT_KEY)) {
            if ($this->isCurrentSession) {
                return $this->session->pull(static::ALERT_KEY);
            } else {
                return $this->session->get(static::ALERT_KEY);
            }
        } else {
            return [];
        }
    }
}
