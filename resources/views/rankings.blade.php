<!doctype html>
<html lang="pt">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Circuito Social Regional de Padel · Rankings</title>

  <style>
    :root{
      --bg:#0b1220;
      --text:#e8eefc;
      --muted:#a9b6d6;
      --line:rgba(255,255,255,.10);
      --chip:rgba(255,255,255,.08);
      --chip2:rgba(255,255,255,.12);
    }
    *{box-sizing:border-box}
    body{
      margin:0;
      font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
      background: radial-gradient(1200px 700px at 20% 0%, rgba(125,211,252,.12), transparent 60%),
                  radial-gradient(1000px 600px at 90% 10%, rgba(52,211,153,.10), transparent 55%),
                  var(--bg);
      color:var(--text);
    }
    .wrap{max-width:1100px;margin:0 auto;padding:28px 16px 64px}
    header{
      display:flex;
      flex-direction:column;
      gap:14px;
      margin-bottom:18px;
    }
    .title h1{margin:0;font-size:22px}
    .title p{margin:6px 0 0;color:var(--muted);max-width:78ch;line-height:1.35}

    .controls{
      display:flex;
      gap:10px;
      align-items:flex-end;
      flex-wrap:wrap;

      background:rgba(255,255,255,.03);
      border:1px solid var(--line);
      padding:10px;
      border-radius:14px;
    }
    .controls label{font-size:12px;color:var(--muted)}
    .controls input,.controls select{
      background:rgba(255,255,255,.04);
      border:1px solid var(--line);
      color:var(--text);
      padding:9px 10px;border-radius:12px;outline:none;min-width:160px;
    }
    .controls-left{align-self:flex-start;}
    .btn{border:1px solid var(--line);background:rgba(255,255,255,.06);color:var(--text);padding:9px 12px;border-radius:12px;cursor:pointer;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:8px;}
    .btn:hover{background:rgba(255,255,255,.09)}
    .status{margin:10px 0 22px;padding:12px 14px;border:1px solid var(--line);background:rgba(255,255,255,.03);border-radius:14px;color:var(--muted);display:none;}

    .back-home{
      display:inline-block;
      margin-bottom:16px;
      padding:8px 12px;
      font-size:13px;
      font-weight:600;
      color:var(--text);
      text-decoration:none;

      border:1px solid var(--line);
      border-radius:999px;
      background:rgba(255,255,255,.05);
    }
    .back-home:hover{background:rgba(255,255,255,.10);}

    .panel{
      border:1px solid var(--line);
      background:rgba(255,255,255,.03);
      border-radius:18px;
      padding:16px;
    }
    .panel h2{margin:0 0 8px;font-size:16px}
    .panel p{margin:0;color:var(--muted);font-size:13px;line-height:1.45}
    .panel code{
      font-size:12px;
      background:rgba(255,255,255,.06);
      border:1px solid var(--line);
      padding:2px 6px;
      border-radius:10px;
      color:rgba(232,238,252,.92);
    }

    .row-actions{
      margin-top:12px;
      display:flex;
      gap:10px;
      flex-wrap:wrap;
      align-items:center;
      justify-content:flex-start;
    }

    .tiny-link{
      color:rgba(232,238,252,.92);
      text-decoration:none;
      border-bottom:1px dashed rgba(255,255,255,.20);
    }
    .tiny-link:hover{border-bottom-color:rgba(255,255,255,.45);}

    .page-footer{
      margin-top:28px;
      padding:18px 0 10px;
      border-top:1px solid var(--line);
      text-align:center;
    }
    .page-footer__copy{
      font-size:12px;
      color:rgba(169,182,214,.7);
    }
    .page-footer__clubs{
      margin-top:10px;
      font-size:12px;
      color:rgba(169,182,214,.6);
      line-height:1.5;
      max-width:900px;
      margin-left:auto;
      margin-right:auto;
      white-space:normal;
      overflow-wrap:anywhere;
    }
    select {
        color-scheme: dark; /* diz ao browser que é dark */
    }

    select option {
        color: #0b1220;          /* texto escuro */
        background-color: #fff; /* fundo claro */
    }
  </style>
</head>

<body>
  <div class="wrap">
    <a href="{{ url('/') }}" class="back-home">← Início</a>

    <header>
      <div class="title">
        <h1 id="rankTitle">Circuito Social Regional de Padel · Rankings</h1>
      </div>

      <div class="controls controls-left">
        <div>
          <label for="cat">Categoria</label><br/>
          </br>
          <select id="cat">
            @foreach($map as $key => $u)
              <option value="{{ $key }}" @selected($key === $selected)>{{ $key }}</option>
            @endforeach
          </select>
        </div>
        <a id="openBtn" class="btn" target="_blank" rel="noopener" href="{{ $url }}">
          Abrir no Tie Player
        </a>
      </div>
    </header>

    <div class="status" id="status"></div>

    <div class="panel">
        <h2>Pré-visualização</h2>

        <div id="iframeWrap" style="
            border:1px solid var(--line);
            border-radius:16px;
            overflow:hidden;
            background:rgba(255,255,255,.02);
            ">
            <iframe
            id="rankFrame"
            src="{{ $url }}"
            title="Ranking {{ $selected }}"
            style="width:100%; height:70vh; border:0; display:block;"
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
        </div>

        <div id="iframeFail" class="status" style="display:none; margin-top:12px;">
            Não foi possível carregar o ranking dentro da página (bloqueio do portal).
            Abre aqui: <a id="directLink2" class="tiny-link" target="_blank" rel="noopener" href="{{ $url }}">{{ $url }}</a>
        </div>
        </div>


    <footer class="page-footer">
      <div class="page-footer__copy">
        © {{ date('Y') }} Circuito Social Regional de Padel
      </div>
      <div class="page-footer__clubs">
        Blitz Padel Club // JF79 Sports Center // MPadel // New Padel // Padel Viseu Academy // Puro Padel Club // Tondela Padel Club
      </div>
    </footer>
  </div>

  <script>
    const MAP = @json($map);
    const INITIAL_CAT = @json($selected);

    const elCat   = document.getElementById("cat");
    const elFrame = document.getElementById("rankFrame");
    const elFail  = document.getElementById("iframeFail");
    const elDirect = document.getElementById("directLink");
    const elDirect2 = document.getElementById("directLink2");
    const elOpen  = document.getElementById("openBtn");
    const elCopy  = document.getElementById("copyBtn");
    const elStatus = document.getElementById("status");

    function setStatus(msg, show=true){
      elStatus.textContent = msg;
      elStatus.style.display = show ? "block" : "none";
    }

    function updateUrlCat(cat){
      const u = new URL(window.location.href);
      u.searchParams.set("cat", String(cat));
      history.replaceState(null, "", u.toString());
    }

    function sync(){
    const cat = elCat.value || INITIAL_CAT;
    const url = MAP[cat] || MAP["M2"];

    // links/botões
    elOpen.href = url;
    if (elDirect) {
        elDirect.href = url;
        elDirect.textContent = url;
    }
    if (elDirect2) {
        elDirect2.href = url;
        elDirect2.textContent = url;
    }

    updateUrlCat(cat);

    // reset aviso de falha
    if (elFail) elFail.style.display = "none";

    // 🔥 refresh imediato do iframe
    if (elFrame) {
        elFrame.title = `Ranking ${cat}`;

        // força recarregamento (mesmo se o browser achar "igual")
        elFrame.src = "about:blank";
        requestAnimationFrame(() => {
        elFrame.src = url;
        });
    }
    }


    elCat.addEventListener("change", () => {
    setStatus("A atualizar pré-visualização…", true);
    sync();
    setTimeout(() => setStatus("", false), 800);
    });

    elCopy.addEventListener("click", async () => {
      const url = elDirect.href;
      try{
        await navigator.clipboard.writeText(url);
        setStatus("Link copiado para a área de transferência ✅", true);
        setTimeout(() => setStatus("", false), 1600);
      }catch(e){
        setStatus("Não foi possível copiar automaticamente. Usa o link direto acima.", true);
      }
    });

    // init
    sync();
  </script>
</body>
</html>
