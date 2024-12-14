@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Quiz</h1>
        <form method="POST" action="{{ route('teacher.quizzes.store', $module->id) }}" id="createQuizForm">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Quiz Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Quiz Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>

            <!-- Questions Section -->
            <div class="mb-3">
                <h4>Questions</h4>
                <button type="button" class="btn btn-secondary mb-3" data-bs-toggle="modal"
                    data-bs-target="#addQuestionModal">Add Question</button>
                <div id="questionsContainer"></div>
            </div>

            <!-- Hidden Input for Questions Data -->
            <input type="hidden" name="questions" id="questionsData">

            <button type="submit" class="btn btn-primary">Create Quiz</button>
        </form>
    </div>

    <!-- Add Question Modal -->
    <div class="modal fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuestionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="addQuestionForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addQuestionModalLabel">Add Question</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="question_text" class="form-label">Question Text</label>
                            <textarea class="form-control" id="question_text" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="question_image" class="form-label">Question Image (Optional)</label>
                            <input type="file" class="form-control" id="question_image" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="question_type" class="form-label">Question Type</label>
                            <select class="form-control" id="question_type" required>
                                <option value="" disabled selected>Please choose question type</option>
                                <option value="0">Single Choice</option>
                                <option value="1">Multiple Choice</option>
                                <option value="2">Short Answer</option>
                            </select>
                        </div>

                        <!-- Answer Options Section -->
                        <div id="answerOptions" class="d-none">
                            <h6>Answers</h6>
                            <div id="answerFields"></div>
                            <button type="button" class="btn btn-secondary add-answer">Add Another Answer</button>
                        </div>

                        <!-- Correct Answer for Short Answer -->
                        <div id="correctAnswerField" class="d-none">
                            <label for="short_correct_answer" class="form-label">Correct Answer (Short Answer)</label>
                            <input type="text" class="form-control" id="short_correct_answer"
                                placeholder="Enter the correct answer">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveQuestionButton">Save Question</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addQuestionForm = document.getElementById('addQuestionForm');
            const saveQuestionButton = document.getElementById('saveQuestionButton');
            const questionsContainer = document.getElementById('questionsContainer');
            const questionsDataInput = document.getElementById('questionsData');
            const questionTypeDropdown = document.getElementById('question_type');
            const answerFields = document.getElementById('answerFields');
            const answerOptions = document.getElementById('answerOptions');
            const correctAnswerField = document.getElementById('correctAnswerField');
            let questions = [];

            // Reset modal when opened
            document.getElementById('addQuestionModal').addEventListener('show.bs.modal', function() {
                addQuestionForm.reset();
                questionTypeDropdown.value = "";
                answerFields.innerHTML = "";
                answerOptions.classList.add('d-none');
                correctAnswerField.classList.add('d-none');
            });

            // Show or hide fields based on question type
            questionTypeDropdown.addEventListener('change', function() {
                if (this.value === '0') { // Single Choice
                    answerOptions.classList.remove('d-none');
                    correctAnswerField.classList.add('d-none');
                    renderAnswerInputs('radio');
                } else if (this.value === '1') { // Multiple Choice
                    answerOptions.classList.remove('d-none');
                    correctAnswerField.classList.add('d-none');
                    renderAnswerInputs('checkbox');
                } else if (this.value === '2') { // Short Answer
                    answerOptions.classList.add('d-none');
                    correctAnswerField.classList.remove('d-none');
                }
            });

            // Add choice logic
            document.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('add-answer')) {
                    const choiceIndex = answerFields.children.length;
                    const type = questionTypeDropdown.value === '0' ? 'radio' : 'checkbox';
                    const choiceDiv = document.createElement('div');
                    choiceDiv.classList.add('input-group', 'mb-2');
                    choiceDiv.innerHTML = `
                <input type="text" class="form-control choice-text" placeholder="Answer Option" required>
                <input type="${type}" name="correct_answer" class="form-check-input correct-choice" value="${choiceIndex}" style="margin: 0 10px;">
                <button type="button" class="btn btn-danger remove-answer">Remove</button>
            `;
                    answerFields.appendChild(choiceDiv);

                    // Remove choice logic
                    choiceDiv.querySelector('.remove-answer').addEventListener('click', function() {
                        choiceDiv.remove();
                    });
                }
            });

            saveQuestionButton.addEventListener('click', function() {
                const questionText = document.getElementById('question_text').value.trim();
                const questionType = addQuestionForm.querySelector('#question_type').value;
                console.log('Selected question type:', questionType);
                const questionImage = document.getElementById('question_image').files[0];

                const choices = Array.from(answerFields.querySelectorAll('.choice-text')).map(input => input
                    .value.trim()).filter(choice => choice !== '');
                const correctAnswers = questionType === '0'
                    ?
                    [Array.from(answerFields.querySelectorAll('.correct-choice')).findIndex(input => input
                        .checked)] :
                    questionType === '1'
                    ?
                    Array.from(answerFields.querySelectorAll('.correct-choice')).map((input, index) => (
                        input.checked ? index : null)).filter(index => index !== null) :
                    [];
                const shortAnswer = questionType === '2' ? document.getElementById('short_correct_answer')
                    .value.trim() : null;

                // Validation
                if (!questionText) {
                    alert('Please enter the question text.');
                    return;
                }
                if ((questionType === '0' || questionType === '1') && choices.length === 0) {
                    alert('Please add at least one choice.');
                    return;
                }
                if (questionType === '0' && correctAnswers.length !== 1) {
                    alert('Please select exactly one correct answer for Single Choice.');
                    return;
                }
                if (questionType === '2' && !shortAnswer) {
                    alert('Please provide the correct answer for the Short Answer question.');
                    return;
                }

                // Prepare image data as Base64
                let questionImageBase64 = null;
                if (questionImage) {
                    const reader = new FileReader();
                    reader.onloadend = function() {
                        questionImageBase64 = reader.result.split(',')[1];
                    };
                    reader.readAsDataURL(questionImage);
                }

                const question = {
                    question_text: questionText,
                    question_type: questionType,
                    question_image: questionImageBase64,
                    points: 1,
                    choices: questionType !== '2' ? choices : [],
                    correct_answers: questionType === '2' ? shortAnswer : correctAnswers,
                };

                questions.push(question);

                // Display the question in the list
                const questionDiv = document.createElement('div');
                questionDiv.classList.add('mb-3');
                questionDiv.innerHTML = `
            <h5>${question.question_text}</h5>
            <p>Type: ${questionType === '0' ? 'Single Choice' : questionType === '1' ? 'Multiple Choice' : 'Short Answer'}</p>
        `;
                if (questionType !== '2') {
                    const choicesList = document.createElement('ul');
                    question.choices.forEach((choice, index) => {
                        const li = document.createElement('li');
                        li.innerHTML =
                            `${choice} ${question.correct_answers.includes(index) ? '<strong>(Correct)</strong>' : ''}`;
                        choicesList.appendChild(li);
                    });
                    questionDiv.appendChild(choicesList);
                } else {
                    questionDiv.innerHTML += `<p>Correct Answer: ${question.correct_answers}</p>`;
                }

                questionsContainer.appendChild(questionDiv);

                // Save questions as JSON in hidden input
                questionsDataInput.value = JSON.stringify(questions);

                // Reset and close modal
                addQuestionForm.reset();
                answerFields.innerHTML = '';
                bootstrap.Modal.getInstance(document.getElementById('addQuestionModal')).hide();
            });

            function renderAnswerInputs(type) {
                Array.from(answerFields.children).forEach(choiceDiv => {
                    const input = choiceDiv.querySelector('.correct-choice');
                    input.setAttribute('type', type);
                });
            }
        });
    </script>
@endsection
