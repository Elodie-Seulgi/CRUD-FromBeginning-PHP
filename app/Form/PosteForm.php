<?php

namespace App\Form;

use App\Core\Form;
use App\Models\Poste;

class PosteForm extends Form
{
    public function __construct(?Poste $poste = null, string $action = "#")
    {
        $this->startForm($action, 'POST', ['class' => 'form card p-3 w-75 mx-auto'])
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('title', 'Titre', ['class' => 'form-label'])
            ->addInput('text', 'title', [
                'class' => 'form-control',
                'id' => 'title',
                'placeholder' => 'Titre du poste',
                'required' => true,
                'value' => $poste?->getTitle(), // le ? avant le -> ça remplace le ternaire si yes getTitle sinon ça s'arrete là
            ])
            ->endDiv()
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('description', 'Description', ['class' => 'form-label'])
            ->addTextarea('description', $poste?->getDescription(), [
                'class' => 'form-control',
                'id' => 'description',
                'rows' => 5,
                'placeholder' => 'Description du poste',
                'required' => true,
            ])
            ->endDiv()
            ->startDiv(['class' => 'mb-3 form-check form-switch'])
            ->addInput('checkbox', 'enabled', [
                'class' => 'form-check-input',
                'id' => 'enabled',
                'checked' => $poste ? $poste->getEnabled() : false,
            ])
            ->addLabel('enabled', 'Actif', ['class' => 'form-check-label'])
            ->endDiv()
            ->addButton('Créer', ['class' => 'btn btn-primary', 'type' => 'submit'])
            ->endForm();
    }
}
