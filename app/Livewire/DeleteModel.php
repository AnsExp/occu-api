<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class DeleteModel extends Component
{
    public string $buttonText = 'Eliminar';
    public bool $open = false;
    public string $title = '¿Estás seguro de eliminar este registro?';
    public string $description = 'Esta acción no se puede deshacer.';
    public ?Model $model = null;

    public function mount(?Model $model = null, ?string $buttonText = null, ?string $title = null, ?string $description = null): void
    {
        $this->model = $model;
        $this->buttonText = $buttonText ?? $this->buttonText;
        $this->title = $title ?? $this->title;
        $this->description = $description ?? $this->description;
    }

    public function openModal(): void
    {
        $this->open = true;
    }

    public function closeModal(): void
    {
        $this->open = false;
    }

    public function delete(): void
    {
        if (! $this->model) {
            return;
        }

        $this->model->delete();
        $this->closeModal();
        session()->flash('status', 'Usuario eliminado correctamente.');
        $this->redirectRoute('users');
    }

    public function render()
    {
        return view('livewire.delete-model');
    }
}
