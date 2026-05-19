<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>تقرير النظام</title>
    <style>
        body {
            font-family: 'xbriyaz', 'DejaVu Sans', sans-serif;
            direction: rtl;
            text-align: right;
            color: #333;
            margin: 0;
            padding: 0;
            font-size: 14px;
        }
        .header {
            width: 100%;
            border-bottom: 2px solid #F15A24;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header table {
            width: 100%;
            border: none;
        }
        .header td {
            vertical-align: middle;
            border: none;
        }
        .logo {
            width: 150px;
            height: auto;
        }
        .title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #4B2991;
        }
        .info-box {
            background-color: #f4f6fb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 30px;
        }
        .info-box table {
            width: 100%;
            border: none;
        }
        .info-box td {
            padding: 5px;
            border: none;
        }
        .info-box strong {
            color: #4B2991;
        }
        .section-title {
            color: #F15A24;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        .stats-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .stats-table th {
            background-color: #4B2991;
            color: #fff;
            padding: 12px;
            text-align: right;
            font-size: 14px;
        }
        .stats-table td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            font-weight: bold;
        }
        .stats-table tr:nth-child(even) td {
            background-color: #f9fafb;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

    <div class="header">
        <table>
            <tr>
                <td style="width: 30%;">
                    <?php $image_path = public_path('assets/logo.png'); ?>
                    @if(extension_loaded('gd') && file_exists($image_path))
                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents($image_path)) }}" class="logo">
                    @else
                        <h2 style="color: #4B2991;">مصادر التنمية</h2>
                    @endif
                </td>
                <td style="width: 70%;" class="title">
                    التقرير التشغيلي الشامل
                    <br>
                    <small style="font-size: 14px; color: #777;">
                        @if($type == 'all') التقرير الكامل @elseif($type == 'students') تقرير الطلاب @elseif($type == 'certificates') تقرير الشهادات @elseif($type == 'detailed') التقارير التفصيلية @else تقرير الموارد البشرية @endif
                    </small>
                </td>
            </tr>
        </table>
    </div>

    <div class="info-box">
        <table>
            <tr>
                <td style="width: 50%;"><strong>تاريخ البداية:</strong> {{ $startDate }}</td>
                <td style="width: 50%;"><strong>تاريخ النهاية:</strong> {{ $endDate }}</td>
            </tr>
            <tr>
                <td><strong>بواسطة مدير النظام:</strong> {{ auth()->user()->name ?? 'مدير النظام' }}</td>
                <td><strong>تاريخ استخراج التقرير:</strong> {{ now()->format('Y-m-d H:i') }}</td>
            </tr>
        </table>
    </div>

    @if(in_array($type, ['all', 'students']))
    <div class="section-title">إحصائيات الطلاب والتسجيلات</div>
    <table class="stats-table">
        <thead>
            <tr>
                <th>البيان</th>
                <th style="width: 30%; text-align: center;">العدد الإجمالي</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>عدد الطلاب المسجلين في الدورات التدريبية</td>
                <td style="text-align: center; color: #4B2991;">{{ $data['course_students'] }} طالب</td>
            </tr>
            <tr>
                <td>عدد الطلاب المسجلين في الامتحانات</td>
                <td style="text-align: center; color: #4B2991;">{{ $data['exam_students'] }} طالب</td>
            </tr>
        </tbody>
    </table>
    @endif

    @if(in_array($type, ['all', 'certificates']))
    <div class="section-title">إحصائيات الشهادات والتوثيق</div>
    <table class="stats-table">
        <thead>
            <tr>
                <th>البيان</th>
                <th style="width: 30%; text-align: center;">العدد الإجمالي</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>عدد الشهادات الرقمية المصدرة للطلاب</td>
                <td style="text-align: center; color: #10b981;">{{ $data['certificates'] }} شهادة</td>
            </tr>
        </tbody>
    </table>
    @endif

    @if(in_array($type, ['all', 'teachers']))
    <div class="section-title">إحصائيات الموارد البشرية والأساتذة</div>
    <table class="stats-table">
        <thead>
            <tr>
                <th>البيان</th>
                <th style="width: 30%; text-align: center;">العدد / القيمة</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>إجمالي طلبات التوظيف (الأساتذة والخبراء)</td>
                <td style="text-align: center;">{{ $data['teachers_total'] }} طلب</td>
            </tr>
            <tr>
                <td>الأساتذة الذين تم توظيفهم</td>
                <td style="text-align: center; color: #f59e0b;">{{ $data['teachers_hired'] }} أستاذ</td>
            </tr>
            <tr>
                <td>إجمالي الرواتب والالتزامات المالية للأساتذة الجدد</td>
                <td style="text-align: center; color: #ef4444;">{{ number_format($data['teachers_salaries'], 2) }} $</td>
            </tr>
        </tbody>
    </table>
    @endif

    @if($type === 'detailed')
    <div class="page-break"></div>
    <div class="section-title">التفاصيل: تسجيلات الدورات التدريبية</div>
    <table class="stats-table">
        <thead><tr><th>اسم الطالب</th><th>رقم الهاتف</th><th>الدورة</th><th>التاريخ</th></tr></thead>
        <tbody>
            @foreach($data['detailed_courses'] ?? [] as $cr)
            <tr>
                <td>{{ $cr->student_name }}</td><td>{{ $cr->phone }}</td><td>{{ $cr->course->name }}</td><td>{{ $cr->created_at->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">التفاصيل: تسجيلات الامتحانات</div>
    <table class="stats-table">
        <thead><tr><th>اسم الطالب</th><th>رقم الهاتف</th><th>الامتحان</th><th>التاريخ</th></tr></thead>
        <tbody>
            @foreach($data['detailed_exams'] ?? [] as $er)
            <tr>
                <td>{{ $er->student_name }}</td><td>{{ $er->phone }}</td><td>{{ $er->exam->subject->name }}</td><td>{{ $er->created_at->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">التفاصيل: الأساتذة والخبراء (الموظفين)</div>
    <table class="stats-table">
        <thead><tr><th>الاسم</th><th>رقم الهاتف</th><th>المجال</th><th>تاريخ التوظيف</th></tr></thead>
        <tbody>
            @foreach($data['detailed_teachers'] ?? [] as $tr)
            <tr>
                <td>{{ $tr->name }}</td><td>{{ $tr->phone }}</td><td>{{ $tr->field->name }}</td><td>{{ $tr->created_at->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div style="margin-top: 50px; text-align: left; padding-left: 50px;">
        <p><strong>توقيع واعتماد مدير النظام:</strong></p>
        <p>___________________________</p>
    </div>

    <div class="footer">
        <p>جميع الحقوق محفوظة &copy; {{ date('Y') }} مصادر التنمية | تم إنشاء هذا التقرير آلياً بواسطة النظام.</p>
        <p>Code; لحلول تقنية المعلومات</p>
    </div>

</body>
</html>
