@extends('layouts.shelter')

@section('content')
<div class="container  d-flex justify-content-center formEdit mt-2">
@if (session('message'))
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
            <div id="toastLoad" class="toast align-items-center border-0 custom-toast" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="toast-icon me-2">
                        <i class="fas fa-paw fa-2x"></i>
                    </div>
                    <div class="custom-toast-body">
                        {{ session('message') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
            <div id="errorToast" class="toast align-items-center border-0 custom-toast" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="toast-icon me-2">
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                    </div>
                    <div class="custom-toast-body">
                        {{session('error')}}
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
    <div class="row col-md-7">
        <div class="text-center my-1">
            <img src="{{ asset('images/dog-paw.jpg') }}" alt="Paw" class="img-fluid" style="max-width: 100px;">
            <h1 class="">Kreiraj obrazac za udomljavanje</h1>
        </div>
        <form action="{{ route('shelter.dogs.storeAdoptionQuestions') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <label for="title" class="form-label">Naslov obrasca</label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                    required>
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="row mb-3">
                <label for="description" class="form-label">Opis obrasca</label>
                <textarea name="description" id="description"
                    class="form-control @error('description') is-invalid @enderror" rows="3"></textarea>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="row mb-3">
                <label for="question_type" class="form-label">Tip pitanja</label>
                <select id="question_type" class="form-select">
                    <option value="" disabled selected>Odaberite tip pitanja</option>
                    <option value="text">Tekst</option>
                    <option value="radio">Radio</option>
                    <option value="checkbox">Checkbox</option>
                </select>
            </div>
            <div id="questions-container">
                <!-- Tu dolaze pitanja -->
            </div>

            <button type="button" id="addQuestion" class="btn btn-secondary mb-3  w-100">Dodaj pitanje</button>
            <button type="submit" class="btn btn-primary w-100 mb-5">Spremi obrazac</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const questionTypeSelect = document.getElementById('question_type');
            const questionsContainer = document.getElementById('questions-container');
            const addQuestionButton = document.getElementById('addQuestion');
            let questionCount = 0;

            addQuestionButton.addEventListener('click', function () {
                const questionType = questionTypeSelect.value;
                if (!questionType) {
                    alert('Molimo odaberite tip pitanja!');
                    return;
                }

                questionCount++;
                const questionElement = document.createElement('div');
                questionElement.classList.add('question-item', 'mb-3');
                const questionId = `question_${questionCount}`;

                let questionHtml = '';
                switch (questionType) {
                    case 'text':
                        questionHtml = `
                        <label for="${questionId}_text" class="form-label">Pitanje ${questionCount} (Tekst)</label>
                        <input type="text" id="${questionId}_text" name="questions[${questionCount - 1}][question_text]" class="form-control mb-2" placeholder="Unesite pitanje" required>
                        <input type="hidden" name="questions[${questionCount - 1}][question_type]" value="text">
                    `;
                        break;
                    case 'radio':
                        questionHtml = `
                        <label for="${questionId}_text" class="form-label">Pitanje ${questionCount} (Radio)</label>
                        <input type="text" id="${questionId}_text" name="questions[${questionCount - 1}][question_text]" class="form-control mb-2" placeholder="Unesite pitanje" required>
                        <div id="${questionId}_options">
                            <input type="text" name="questions[${questionCount - 1}][options][]" class="form-control mb-2" placeholder="Opcija 1" required>
                            <input type="text" name="questions[${questionCount - 1}][options][]" class="form-control mb-2" placeholder="Opcija 2" required>
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm add-option" data-target="${questionId}_options">Dodaj Opciju</button>
                        <input type="hidden" name="questions[${questionCount - 1}][question_type]" value="radio">
                    `;
                        break;
                    case 'checkbox':
                        questionHtml = `
                        <label for="${questionId}_text" class="form-label">Pitanje ${questionCount} (Checkbox)</label>
                        <input type="text" id="${questionId}_text" name="questions[${questionCount - 1}][question_text]" class="form-control mb-2" placeholder="Unesite pitanje" required>
                        <div id="${questionId}_options">
                            <input type="text" name="questions[${questionCount - 1}][options][]" class="form-control mb-2" placeholder="Opcija 1" required>
                            <input type="text" name="questions[${questionCount - 1}][options][]" class="form-control mb-2" placeholder="Opcija 2" required>
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm add-option" data-target="${questionId}_options">Dodaj Opciju</button>
                        <input type="hidden" name="questions[${questionCount - 1}][question_type]" value="checkbox">
                    `;
                        break;
                }

                questionElement.innerHTML = questionHtml + '<button type="button" class="btn btn-danger btn-sm remove-question">Ukloni pitanje</button>';
                questionsContainer.appendChild(questionElement);
                questionTypeSelect.value = '';
            });

            questionsContainer.addEventListener('click', function (event) {
                if (event.target.classList.contains('remove-question')) {
                    event.target.parentElement.remove();
                    reindexQuestions();
                }

                if (event.target.classList.contains('add-option')) {
                    const containerId = event.target.getAttribute('data-target');
                    const container = document.getElementById(containerId);
                    const optionCount = container.querySelectorAll('input[type="text"]').length + 1;
                    const newOption = document.createElement('input');
                    newOption.type = 'text';
                    newOption.classList.add('form-control', 'mb-2');
                    newOption.placeholder = `Opcija ${optionCount}`;
                    newOption.name = `questions[${questionsContainer.children.length - 1}][options][]`;
                    container.appendChild(newOption);
                }
            });

            function reindexQuestions() {
                const questionItems = questionsContainer.querySelectorAll('.question-item');
                questionItems.forEach((item, index) => {
                    const questionNumber = index + 1;
                    item.querySelector('label').textContent = `Pitanje ${questionNumber}`;
                    const inputs = item.querySelectorAll('input[name^="questions"]');
                    inputs.forEach(input => {
                        const name = input.name;
                        if (name.includes('question_text') || name.includes('question_type')) {
                            input.name = `questions[${index}][${name.split('[')[1].split(']')[0]}]`;
                        } else if (name.includes('options')) {
                            input.name = `questions[${index}][options][]`;
                        }
                    });
                    item.querySelectorAll('input[name$="[options][]"]').forEach((input, optionIndex) => {
                        input.placeholder = `Opcija ${optionIndex + 1}`;
                    });
                });
            }
        });

    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var toastElement = document.getElementById('toastLoad');
        if (toastElement) {
            var toast = new bootstrap.Toast(toastElement, {
                delay: 5000
            });
            toast.show();
        }
    });
</script><script>
    document.addEventListener('DOMContentLoaded', function () {
        var toastElement = document.getElementById('errorToast');
        if (toastElement) {
            var toast = new bootstrap.Toast(toastElement, {
                delay: 5000
            });
            toast.show();
        }
    });
</script>
@endpush
