<?php

namespace Itb;

class Visitor
{
    private $id;
    private $aName;
    private $aEmail;
    private $aPassword;
    private $emailNotify;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getAName()
    {
        return $this->aName;
    }

    /**
     * @param mixed $aName
     */
    public function setAName($aName)
    {
        $this->aName = $aName;
    }

    /**
     * @return mixed
     */
    public function getAEmail()
    {
        return $this->aEmail;
    }

    /**
     * @param mixed $aEmail
     */
    public function setAEmail($aEmail)
    {
        $this->aEmail = $aEmail;
    }

    /**
     * @return mixed
     */
    public function getAPassword()
    {
        return $this->aPassword;
    }

    /**
     * @param mixed $aPassword
     */
    public function setAPassword($aPassword)
    {
        // $this->aPassword = $aPassword;

        $password_hashed = password_hash($aPassword, PASSWORD_DEFAULT);

        return $this->$password_hashed;
    }

    /**
     * @return mixed
     */
    public function getEmailNotify()
    {
        return $this->emailNotify;
    }

    /**
     * @param mixed $emailNotify
     */
    public function setEmailNotify($emailNotify)
    {
        $this->emailNotify = $emailNotify;
    }

    public function __toString()
    {
        $text = '';
        $text .= 'id = ' . $this->id;
        $text .= ', aName = ' . $this->aName;
        $text .= ', aEmail = ' . $this->aEmail;
        $text .= ', aPassword = ' . $this->aPassword;
        $text .= ', emailNotify' . $this->emailNotify;

        return $text;
    }
}