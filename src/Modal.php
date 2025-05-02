<?php

namespace Jump\JumpDataTable;

class Modal
{
    private string $id;
    private string $title;
    private string $message;
    private string $formAction;
    private string $submitText;
    private string $cancelText;
    private bool $includePasswordField;
    private string $submitButtonClass;
    private string $cancelButtonClass;

    public function __construct(
        string $id = 'customModal',
        string $title = 'Confirmer l\'action',
        string $message = 'Êtes-vous sûr de vouloir effectuer cette action ?',
        string $formAction = '#',
        string $submitText = 'Confirmer',
        string $cancelText = 'Annuler',
        bool $includePasswordField = false,
        string $submitButtonClass = 'bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 dark:bg-red-700 dark:hover:bg-red-800',
        string $cancelButtonClass = 'bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 dark:bg-gray-700 dark:hover:bg-gray-800'
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->message = $message;
        $this->formAction = $formAction;
        $this->submitText = $submitText;
        $this->cancelText = $cancelText;
        $this->includePasswordField = $includePasswordField;
        $this->submitButtonClass = $submitButtonClass;
        $this->cancelButtonClass = $cancelButtonClass;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'message' => $this->message,
            'formAction' => $this->formAction,
            'submitText' => $this->submitText,
            'cancelText' => $this->cancelText,
            'includePasswordField' => $this->includePasswordField,
            'submitButtonClass' => $this->submitButtonClass,
            'cancelButtonClass' => $this->cancelButtonClass
        ];
    }

    public function render(): string
    {
        ob_start();
        ?>
        <div id="<?= $this->id ?>" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white p-6 rounded-lg shadow-lg dark:bg-gray-800">
                <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100"><?= $this->title ?></h2>
                <p class="mb-6 text-gray-700 dark:text-gray-300"><?= $this->message ?></p>
                
                <form id="<?= $this->id ?>Form" action="<?= $this->formAction ?>" method="POST">
                    <?php if ($this->includePasswordField): ?>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 dark:text-gray-300">Mot de passe</label>
                            <input type="password" name="password" required
                                   class="w-full px-3 py-2 border rounded dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
                        </div>
                    <?php endif; ?>
                    
                    <div class="flex justify-end space-x-4">
                        <button type="button" onclick="closeModal('<?= $this->id ?>')"
                                class="<?= $this->cancelButtonClass ?>">
                            <?= $this->cancelText ?>
                        </button>
                        <button type="submit"
                                class="<?= $this->submitButtonClass ?>">
                            <?= $this->submitText ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    public function getScript(): string
    {
return <<<JS
        <script>
            function openModal(modalId) {
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.classList.remove('hidden');
                } else {
                    console.error(`Modal with ID \${modalId} not found.`);
                }
            }

            function closeModal(modalId) {
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.classList.add('hidden');
                } else {
                    console.error(`Modal with ID \${modalId} not found.`);
                }
            }
        </script>
JS;
    }

    // Getters et Setters
    public function getId(): string { return $this->id; }
    public function getTitle(): string { return $this->title; }
    public function getMessage(): string { return $this->message; }
    public function getFormAction(): string { return $this->formAction; }
    public function getSubmitText(): string { return $this->submitText; }
    public function getCancelText(): string { return $this->cancelText; }
    public function getIncludePasswordField(): bool { return $this->includePasswordField; }

    public function setTitle(string $title): self { $this->title = $title; return $this; }
    public function setMessage(string $message): self { $this->message = $message; return $this; }
    public function setFormAction(string $formAction): self { $this->formAction = $formAction; return $this; }
    public function setSubmitText(string $submitText): self { $this->submitText = $submitText; return $this; }
    public function setCancelText(string $cancelText): self { $this->cancelText = $cancelText; return $this; }
    public function setIncludePasswordField(bool $includePasswordField): self { $this->includePasswordField = $includePasswordField; return $this; }
    public function setSubmitButtonClass(string $class): self { $this->submitButtonClass = $class; return $this; }
    public function setCancelButtonClass(string $class): self { $this->cancelButtonClass = $class; return $this; }
}