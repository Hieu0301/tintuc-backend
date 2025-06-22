<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Bài viết mới</title>
</head>

<body style="font-family: sans-serif;">
    <h2>📢 {{ $article->title }}</h2>

    <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="Ảnh bài viết"
        style="max-width: 100%; border-radius: 8px; margin-bottom: 15px;">

    <p>{{ Str::limit(strip_tags($article->content), 150) }}</p>

    <p>
        <a href="http://localhost:3000/article/{{ $article->id }}"
            style="display: inline-block; padding: 10px 20px; background: #000; color: #fff; text-decoration: none; border-radius: 5px;">
            Xem chi tiết
        </a>
    </p>

    <p>Cảm ơn bạn đã theo dõi!</p>
</body>

</html>
