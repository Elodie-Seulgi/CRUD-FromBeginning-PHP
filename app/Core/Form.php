<?php

namespace App\Core;

/**
 * Class de génération de formulaire
 */
class Form
{
    /**
     * Propriété pour stocker le code HTML du formulaire
     */
    protected string $formCode = '';

    public static function validate(array $requireFields, array $submitFields): bool
    {
        // ['email', 'password','lastName','firstName']
        // ['email' => 'test@test.com', 'password' => 'test', 'lastName' => 'Doe', 'firstName' => 'Joe']
        // TODO On boucle sur le tableau de champs obligatoires
        foreach ($requireFields as $requireField) {
            if (empty($submitFields[$requireField]) || strlen(trim($submitFields[$requireField])) === 0) {
                return false;
            }
        }
 
        return true;
    }

    public function startForm(string $action, string $method = "POST", array $attributs = []): static
    {
        // <form action="*" method="POST"
        $this->formCode .= "<form action=\"$action\" method=\"$method\"";

        // On ajoute les attributs HTML potentiel
        $this->formCode .= $this->addAttributs($attributs) . '>';

        return $this;

    }

    public function endForm(): static
    {
        $this->formCode .= '</form>';

        return $this;
    }

    public function startDiv(array $attributs = []): static
    {
        $this->formCode .= '<div ' . $this->addAttributs($attributs) . '>';

        return $this;
    }

    public function endDiv(): static
    {
        $this->formCode .= '</div>';

        return $this;
    }

    public function addLabel(string $for, string $text, array $attributs = []): static
    {
        // <label for="email">Email</label>
        $this->formCode .= "<label for=\"$for" . $this->addAttributs($attributs) . ">$text</label>";

        return $this;
    }

    public function addInput(string $type, string $name, array $attributs = []): static
    {
        // <input type="email" name="email" id="email">
        $this->formCode .= "<input type=\"$type\" name=\"$name\"" . $this->addAttributs($attributs) . '/>';

        return $this;
    }

    public function addButton(string $text, array $attributs = []): static
    {
        // <button type="submit" class="btn btn-primary">Envoyer</button>
        $this->formCode .= "<button type=\"submit\"" . $this->addAttributs($attributs) . ">$text</button>";

        return $this;
    }


    /**
     * 
     * Ajoute les attributs envoyés à la balise html
     * @return void
     */
    public function addAttributs(array $attributs): string
    {
        // On crée une chaîne de caractères vides
        $attributsString = '';
        // On liste les attributs courts
        $courts = ['checked', 'disabled', 'readonly', 'multiple', 'required', 'autofocus', 'novalidate', 'selected', 'formnovalidate'];

        // On boucle sur le tableau d'attributs
        foreach ($attributs as $key => $value) {
            // On crée une chaîne de caractères pour les attributs courts
            if (in_array($key, $courts)) {
                $attributsString .= " $key";
            } else {
                // On crée une chaîne de caractères pour les attributs longs
                $attributsString .= $key . '="' . $value . '" ';
            }
        }
        return $attributsString;
    }


    /**
     * Renvoie le code HTML du formulaire stocké dans la propriété $formCode
     * @return string
     */
    public function createForm(): string
    {
        return $this->formCode;
    }


}