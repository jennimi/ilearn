<!DOCTYPE html>
<html>

<head>
    <title>Ask Gemini</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>

<body class="p-5">
    <div class="container">
        <h1>Ask Gemini</h1>

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Section -->
        <form action="{{ route('gemini.ask') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="query" class="form-label">Your Question</label>
                <textarea class="form-control" id="query" name="query" rows="3" required>{{ old('query', $query ?? '') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Ask</button>
        </form>

        <!-- Results Section -->
        @if (!empty($query))
            <hr>
            <h2>Results</h2>

            @if (is_array($response) && isset($response['error']))
                <div class="alert alert-danger">
                    <strong>Error:</strong> {{ $response['message'] }}
                </div>
            @else
                <div class="alert alert-success">
                    <strong>Response:</strong> {{ $response }}
                </div>

                <!-- Display Quiz -->
                @if (isset($quiz) && is_array($quiz))
                    <div class="mt-4">
                        <h3>Quiz</h3>
                        @foreach ($quiz as $question)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Question:</h5>
                                    <p class="card-text">{{ $question['question'] }}</p>

                                    <h6 class="card-subtitle mb-2 text-muted">Answer:</h6>
                                    <p class="card-text">{{ $question['answer'] }}</p>

                                    <h6 class="card-subtitle mb-2 text-muted">Options:</h6>
                                    <ul class="list-group list-group-flush">
                                        @foreach ($question['options'] as $option)
                                            <li class="list-group-item">{{ $option }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>No quiz data available.</p>
                @endif
            @endif
        @endif
    </div>
</body>

</html>
