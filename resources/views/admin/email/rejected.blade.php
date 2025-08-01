<!DOCTYPE html>
<html>
<head>
    <title>Your Post Needs Revisions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #2d3748;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4299e1;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
        }
        .reason {
            background-color: #fffaf0;
            padding: 15px;
            border-left: 4px solid #e53e3e;
            margin: 15px 0;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #718096;
        }
    </style>
</head>
<body>
    <div class="header">Your Post Needs Revisions</div>
    
    <p>Your post "<strong>{{ $post->title }}</strong>" was not approved and has been moved back to drafts.</p>
    
    <div class="reason">
        <strong>Reason:</strong><br>
        Please review the content and make necessary changes before resubmitting.
    </div>
    
    <a href="{{ route('admin.posts.edit', $post->id) }}" class="button">Edit Post</a>
    
    <div class="footer">
        Thanks,<br>
        {{ config('app.name') }}
    </div>
</body>
</html>