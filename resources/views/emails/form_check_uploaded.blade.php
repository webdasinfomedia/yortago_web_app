<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Yortago - New Form Check</title>
</head>
<body style="margin:0;padding:0;font-family:Arial,sans-serif;background-color:#f4f4f4;">
<center style="width:100%;background-color:#f4f4f4;padding:20px 0;">
<table width="600" border="0" cellspacing="0" cellpadding="0" style="max-width:600px;margin:0 auto;background-color:#ffffff;">
<!-- Header -->
<tr>
<td style="background:#1a1a1a;padding:30px 40px;text-align:center;">
<h1 style="margin:0;font-size:32px;font-weight:800;color:#ffffff;letter-spacing:1px;">YOR<span style="color:#d76e33;">TAGO</span></h1>
<p style="color:#cccccc;font-size:12px;margin:8px 0 0 0;text-transform:uppercase;letter-spacing:2px;">SPORTS PERFORMANCE TRAINING</p>
</td>
</tr>

<!-- Main Content -->
<tr>
<td style="padding:40px;color:#333333;">
<h1 style="color:#1a1a1a;font-size:24px;margin:0 0 20px 0;font-weight:700;">New Form Check Uploaded</h1>
<p style="margin:15px 0;font-size:15px;line-height:1.6;">Hello <strong>Admin</strong>,</p>
<p style="margin:15px 0;font-size:15px;line-height:1.6;"><strong>{{ $user->name }}</strong> has uploaded a new video for form check.</p>

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:25px 0;">
<tr>
<td style="background-color:#f8f9fa;border-left:4px solid #d76e33;padding:20px;">
<strong style="color:#1a1a1a;display:block;margin-bottom:8px;font-size:14px;text-transform:uppercase;letter-spacing:0.5px;">ATHLETE DETAILS:</strong>
<p style="color:#555555;font-size:15px;line-height:1.6;margin:0;">
<strong>Name:</strong> {{ $user->name }}<br>
<strong>Email:</strong> {{ $user->email }}
</p>
</td>
</tr>
</table>

<center>
<a href="{{ $videoUrl }}" style="display:inline-block;background:#d76e33;color:#ffffff;text-decoration:none;padding:14px 32px;border-radius:6px;font-weight:600;font-size:15px;margin:20px 0;" target="_blank">Review Video</a>
</center>

<p style="margin:15px 0;font-size:15px;line-height:1.6;">Please review the video and provide feedback to help the athlete improve their form.</p>

<p style="margin:30px 0 0 0;font-size:15px;line-height:1.6;">
<strong>Yortago Admin Panel</strong><br>
The Yortago Support Team
</p>
</td>
</tr>

<!-- Footer -->
<tr>
<td style="background-color:#1a1a1a;color:#999999;padding:30px 40px;text-align:center;font-size:13px;">
<h3 style="margin:0 0 15px 0;font-size:20px;font-weight:700;color:#ffffff;letter-spacing:1px;">YOR<span style="color:#d76e33;">TAGO</span></h3>
<p style="color:#cccccc;font-size:12px;margin:0 0 20px 0;text-transform:uppercase;letter-spacing:2px;">Accelerate speed, boost explosiveness, enhance strength</p>
<div style="height:1px;background-color:#333333;margin:20px 0;"></div>
<p style="margin:8px 0;color:#999999;">Questions? Contact us at <a href="mailto:info@yortago.com" style="color:#d76e33;text-decoration:none;">info@yortago.com</a></p>
<p style="margin:15px 0 0 0;font-size:12px;color:#666666;">© {{ date('Y') }} Yortago. All rights reserved.<br>This is an admin notification email</p>
</td>
</tr>
</table>
</center>
</body>
</html>