<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ask Gemini</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <form action="{{ route('gemini.ask') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="file" class="form-label">Upload Your File (PDF/TXT)</label>
                <input class="form-control" type="file" id="file" name="file" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <!-- Display Uploaded File Name Before Response -->
        @if (!empty($fileName))
            <div class="mt-4">
                <h3>File Uploaded: {{ $fileName }}</h3>
            </div>
        @endif

        <!-- Results Section -->
        @if (!empty($response))
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
