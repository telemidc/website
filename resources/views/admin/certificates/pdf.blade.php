<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
    * { margin:0; padding:0; }
    body {
        font-family: 'xbriyaz', 'DejaVu Sans', sans-serif;
        background: #fff;
        color: #1a1a2e;
        padding: 7mm;
    }
    /* ── Outer frame: thick purple border ── */
    .f-outer {
        border: 5px solid #2d1b69;
        padding: 3.5mm;
        background: #fff;
        text-align: center;
    }
    /* ── Inner frame: thin gold border ── */
    .f-inner {
        border: 1.5px solid #c9a84c;
        padding: 4mm 14mm 4mm;
    }
    /* ── Decorative top/bottom bars ── */
    .bar { width:100%; height:2.2mm; background:#2d1b69; }
    .bar-top  { margin-bottom:5mm; }
    .bar-bot  { margin-top:5mm; }

    /* ── Branding ── */
    .brand { font-size:7pt; color:#2d1b69; font-weight:700; letter-spacing:2.5mm; text-transform:uppercase; margin-bottom:2mm; }
    .logo-img { height:14mm; margin-bottom:2.5mm; }

    /* ── Certificate title ── */
    .title { font-size:21pt; font-weight:800; color:#2d1b69; text-transform:uppercase; letter-spacing:1mm; margin-bottom:1mm; }
    .subtitle { font-size:6.5pt; color:#c9a84c; text-transform:uppercase; letter-spacing:3mm; font-weight:700; margin-bottom:4mm; }

    /* ── Body ── */
    .certify  { font-size:8.5pt; color:#777; font-style:italic; margin-bottom:2mm; }
    .s-name   { font-size:18pt; font-weight:800; color:#1a1a2e; border-bottom:1pt solid #c9a84c; display:inline-block; padding:0 8mm 1.5mm; margin-bottom:3.5mm; font-family:'xbriyaz','DejaVu Sans',sans-serif; }
    .c-label  { font-size:8.5pt; color:#777; margin-bottom:1.5mm; }
    .c-name   { font-size:11.5pt; font-weight:700; color:#2d1b69; margin-bottom:3.5mm; font-family:'xbriyaz','DejaVu Sans',sans-serif; }

    /* ── Grade badge ── */
    .g-label  { font-size:5.5pt; color:#999; text-transform:uppercase; letter-spacing:1mm; margin-bottom:1.5mm; }
    .g-pill   { background:#F15A24; color:#fff; padding:1.5mm 10mm; font-size:10pt; font-weight:700; display:inline-block; margin-bottom:4.5mm; font-family:'xbriyaz','DejaVu Sans',sans-serif; }

    /* ── Footer ── */
    .footer   { display:table; width:100%; border-top:0.5pt solid #ddd; padding-top:3.5mm; }
    .fc       { display:table-cell; width:33.33%; text-align:center; vertical-align:bottom; }
    .sig-val  { font-size:7.5pt; font-weight:700; color:#1a1a2e; margin-bottom:2mm; font-family:'xbriyaz','DejaVu Sans',sans-serif; }
    .sig-line { border-top:0.5pt solid #bbb; width:44mm; margin:0 auto 1.5mm; }
    .sig-lbl  { font-size:5.5pt; color:#999; text-transform:uppercase; letter-spacing:0.5mm; }
    .cert-no  { font-size:6.5pt; color:#bbb; font-family:monospace; line-height:1.6; }

    /* ── Arabic text ── */
    .ar { font-family:'xbriyaz','DejaVu Sans',sans-serif; direction:rtl; unicode-bidi:bidi-override; }
</style>
</head>
<body>
<div class="f-outer">
  <div class="f-inner">

    <div class="bar bar-top"></div>

    <img class="logo-img" src="var:logoimg" alt="CRD Logo">

    <div class="title">Certificate of Completion</div>
    <div class="subtitle">&#11835;&nbsp; Awarded for Excellence &nbsp;&#11835;</div>

    <div class="certify">This is to certify that</div>
    <div><span class="s-name ar">{{ $certificate->registration->student_name }}</span></div>

    <div class="c-label">has successfully completed the training course</div>
    <div class="c-name ar">{{ $certificate->registration->course->name }}</div>

    <div class="g-label">Grade Achieved</div>
    <div><span class="g-pill ar">{{ $certificate->grade }}</span></div>

    <div class="footer">
      <div class="fc">
        <div class="sig-val">{{ \Carbon\Carbon::parse($certificate->issued_at)->format('F d, Y') }}</div>
        <div class="sig-line"></div>
        <div class="sig-lbl">Date of Issue</div>
      </div>
      <div class="fc">
        <div class="cert-no">
          Certificate No.<br>{{ $certificate->certificate_number }}
        </div>
      </div>
      <div class="fc">
        <div class="sig-val">CRD Administration</div>
        <div class="sig-line"></div>
        <div class="sig-lbl">Authorized Signature</div>
      </div>
    </div>

    <div class="bar bar-bot"></div>

  </div>
</div>
</body>
</html>
