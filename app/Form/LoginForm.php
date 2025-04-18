<?php

namespace App\Form;

use App\Core\Form;

class LoginForm extends Form
{
    public function __construct()
    {
        $this
            ->startForm('/login', 'POST', [
                'class' => 'form card p-3 w-50 mx-auto',
                'id' => 'form-login',
            ])
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('email', 'Email:', [
                'class' => 'form-label',
            ])
            ->addInput('email', 'email', [
                'class' => 'form-control',
                'placeholder' => 'john@example.com',
                'id' => 'email',
                'required' => true,
            ])
            ->endDiv()
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('password', 'Mot de passe:', [
                'class' => 'form-label',
            ])
            ->addInput('password', 'password', [
                'id' => 'password',
                'class' => 'form-control',
                'placeholder' => 'S3CR3T',
                'required' => true,
            ])
            ->endDiv()
            ->addButton('Connexion', [
                'class' => 'btn btn-primary',
            ])
            ->endForm();
    }
}