<!doctype html>
<html lang="pt">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Circuito social Regional de Padel</title>

  <style>
    :root{
      --bg:#0b1220;
      --panel:#101a2e;
      --text:#e8eefc;
      --muted:#a9b6d6;
      --line:rgba(255,255,255,.12);
      --accent:#7dd3fc;
      --disabled:#6b7280;
    }

    *{ box-sizing:border-box; }

    body{
      margin:0;
      min-height:100vh;
      display:flex;
      align-items:center;
      justify-content:center;
      font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
      background:
        radial-gradient(1200px 700px at 20% 0%, rgba(125,211,252,.12), transparent 60%),
        radial-gradient(1000px 600px at 90% 10%, rgba(52,211,153,.10), transparent 55%),
        var(--bg);
      color:var(--text);
    }

    .card{
      width:100%;
      max-width:520px;
      padding:36px 28px 40px;
      background:rgba(255,255,255,.04);
      border:1px solid var(--line);
      border-radius:22px;
      text-align:center;
      box-shadow: 0 20px 60px rgba(0,0,0,.35);
    }

    h1{
      margin:0 0 10px;
      font-size:26px;
      letter-spacing:.4px;
    }

    p{
      margin:0 0 28px;
      color:var(--muted);
      font-size:15px;
    }

    .actions{
      display:flex;
      gap:14px;
      justify-content:center;
      flex-wrap:wrap;
    }

    .btn{
      min-width:160px;
      padding:14px 18px;
      border-radius:16px;
      font-size:15px;
      font-weight:700;
      letter-spacing:.3px;
      text-decoration:none;
      border:1px solid var(--line);
      background:rgba(255,255,255,.06);
      color:var(--text);
      cursor:pointer;
      transition: all .15s ease;
    }

    .btn.primary{
      background:linear-gradient(135deg, rgba(125,211,252,.22), rgba(125,211,252,.12));
      border-color:rgba(125,211,252,.35);
    }

    .btn.primary:hover{
      transform: translateY(-1px);
      background:linear-gradient(135deg, rgba(125,211,252,.32), rgba(125,211,252,.18));
    }

    .btn.disabled{
      cursor:not-allowed;
      color:var(--disabled);
      background:rgba(255,255,255,.02);
      border-color:rgba(255,255,255,.08);
      opacity:.65;
    }

    .btn.disabled:hover{
      transform:none;
      background:rgba(255,255,255,.02);
    }

    footer{
      margin-top:26px;
      font-size:12px;
      color:rgba(169,182,214,.7);
    }
  </style>
</head>

<body>
  <div class="card">
    <h1>Circuito Social Regional de Padel</h1>
    <p>Calendário oficial de torneios / Rankings do circuito.</p>

    <div class="actions">
      <a href="{{ url('/calendario') }}" class="btn primary">
        Calendário
      </a>

      <span class="btn disabled" aria-disabled="true">
        Ranking
      </span>
    </div>

    <footer>
      © {{ date('Y') }} Circuito Social Regional de Padel
        </br></br>
        Blitz Padel Club // JF79 Sports Center // MPadel // New Padel // Padel Viseu Academy // Puro Padel Club // Tondela Padel Club
    </footer>
  </div>
</body>
</html>
