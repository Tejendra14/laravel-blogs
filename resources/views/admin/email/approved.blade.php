<!DOCTYPE html>
<html>
<head>
    <title>Your Post Has Been Approved</title>
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
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #718096;
        }
    </style>
</head>
<body>
    <div class="header">Your Post Has Been Approved</div>
    
    <p>Your post "<strong>{{ $post->title }}</strong>" has been approved and published.</p>
    
    <a href="{{ route('admin.posts.show', $post->slug) }}" class="button">View Post</a>
    
    <div class="footer">
        Thanks,<br>
        {{ config('app.name') }}
    </div>
</body>
</html>