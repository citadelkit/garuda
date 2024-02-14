<?php

namespace CitadelKit\Garuda;

use CitadelKit\Garuda\Traits\Makeable;

class Form
{
    use Makeable;

    protected $view = "components.form";

    protected $action = "/";
    protected $method = "POST";
    protected $data = [];
    protected $withConfirmation = true;
    protected $withSaveAsDraft = true;
    protected $withSaveAndContinue = true;
    protected $isEditForm = false;
    protected $isViewForm = false;

    protected $saveAsDraftLabel = "Simpan sebagai Draft";
    protected $saveAndContinueLabel = "Simpan dan lanjutkan";
    protected $isEditFormLabel = "Simpan perubahan";

    protected $goToedit = "Edit";
    protected $sections = [];

    protected $formActions = [];

    public function getData()
    {
        return array_merge([
            'form_action' => $this->action,
            'form_method' => $this->method,
            'withConfirmation' => $this->withConfirmation,
            'withSaveAsDraft' => $this->withSaveAsDraft,
            'withSaveAndContinue' => $this->withSaveAndContinue,
            'isEditForm' => $this->isEditForm,
            'withSaveAndContinue' => $this->withSaveAndContinue,

            'isViewForm' => $this->isViewForm,
            'goToedit' => $this->goToedit,
          

        ], $this->data);
    }

    public function url($path = null, $parameters = [], $secure = null)
    {
        $this->action = url($path, $parameters, $secure);
        return $this;
    }

    public function route($name, $parameters = [], $absolute = true)
    {
        $this->action = route($name, $parameters, $absolute);
        return $this;
    }

    public function data($data = [])
    {
        $this->data = $data;
        return $this;
    }

    public function method($method = "POST")
    {
        $this->method = $method;
        return $this;
    }

    public function view($view, $data = [])
    {
        $this->sections[] = view($view, $data, $this->getData());
        return $this;
    }

    public function renderSection()
    {
        $html = "";
        foreach ($this->sections as $section) {
            $html .= $section->render();
        }
        return $html;
    }

    public function isEditForm($value = true)
    {
        $this->isEditForm = $value;
        $this->withSaveAndContinue = false;
        $this->withSaveAsDraft = false;
        $this->withConfirmation = false;
        return $this;
    }

    public function isViewForm($value = true)
    {
        $this->isViewForm = $value;
        $this->withSaveAndContinue = false;
        $this->withSaveAsDraft = false;
        $this->withConfirmation = false;
        return $this;
    }

   

    public function formActions($formActions = []) {
        $this->formActions = $formActions;
        return $this;
    }


    public function withSaveAsDraft($value = true)
    {
        $this->withSaveAsDraft = $value;
        return $this;
    }

    public function withSaveAndContinue($value = true)
    {
        $this->withSaveAndContinue = $value;
        return $this;
    }

    public function withConfirmation($value = true)
    {
        $this->withConfirmation = $value;
        return $this;
    }

    public function saveAsDraftLabel($label = "Simpan sebagai Draft")
    {
        $this->saveAsDraftLabel = $label;
        return $this;
    }

    public function saveAndContinueLabel($label = "Simpan dan lanjutkan")
    {
        $this->saveAndContinueLabel = $label;
        return $this;
    }

    public function isEditFormLabel($label = "Simpan perubahan")
    {
        $this->isEditFormLabel = $label;
        return $this;
    }



    public function goToedit($label = "Edit")
    {
        $this->goToedit = $label;
        return $this;
    }

    public function LabelApproval($label = "Approval")
    {
        $this->LabelApproval = $label;
        return $this;
    }

    public function render()
    {
        $data = json_encode($this->data);
        return view($this->view, [
            'form_action' => $this->action,
            'form_method' => $this->method,
            'withConfirmation' => $this->withConfirmation,
            'withSaveAsDraft' => $this->withSaveAsDraft,
            'withSaveAndContinue' => $this->withSaveAndContinue,
            'isEditForm' => $this->isEditForm,
            'sections' => $this->sections,
            'saveAsDraftLabel' => $this->saveAsDraftLabel,
            'saveAndContinueLabel' => $this->saveAndContinueLabel,
            'isEditFormLabel' => $this->isEditFormLabel,
            'isViewForm' => $this->isViewForm,
            'goToedit' => $this->goToedit,
            'formActions' => $this->formActions
        ]);
    }
}
