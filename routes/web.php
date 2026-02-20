<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/calendario', function (Request $request) {
    // Ano via ?events-year=2026 (igual ao exemplo)
    $year = (int)($request->query('events-year', now()->year));

    return view('calendario', [
        'year' => $year,
    ]);
});

Route::get('/api/calendario', function (Request $request) {
    $year = (int)($request->query('year', now()->year));
    $q = trim((string)$request->query('q', ''));

    $start = sprintf('%04d-01-01', $year);
    $end   = sprintf('%04d-12-31', $year);

    $base = rtrim(config('services.padel_calendar_supabase.url'), '/');
    $key  = config('services.padel_calendar_supabase.anon');

    $url = $base . '/rest/v1/v_torneios_com_categorias';

    // filtro por ano (data_inicio)
    $params = [
        'select' => 'id,nome,clube,data_inicio,data_fim,preco_publico,preco_socio,categorias,banner_path,url_inscricao',
        'data_inicio' => "gte.$start",
        'data_inicio' => "gte.$start", // placeholder (vai ser sobrescrito? não)
    ];

    // Em vez de params duplicados, vamos montar query manualmente (mais claro)
    $query = http_build_query([
        'select' => 'id,nome,clube,clube_logo_path,data_inicio,data_fim,preco_publico,preco_socio,categorias,banner_path,url_inscricao',
        'data_inicio' => "gte.$start",
        'data_inicio' => "gte.$start",
    ]);

    // Laravel não gosta de keys repetidas em arrays; fazemos query string manual:
    $query = 'select=' . rawurlencode('id,nome,clube,clube_logo_path,data_inicio,data_fim,preco_publico,preco_socio,categorias,banner_path,url_inscricao')
           . '&data_inicio=gte.' . rawurlencode($start)
           . '&data_inicio=lte.' . rawurlencode($end)
           . '&order=' . rawurlencode('data_inicio.asc');

    $res = Http::withHeaders([
        'apikey' => $key,
        'Authorization' => 'Bearer ' . $key,
        'Accept' => 'application/json',
    ])->get($url . '?' . $query);

    if (!$res->ok()) {
        return response()->json([
            'error' => 'Supabase error',
            'status' => $res->status(),
            'body' => $res->json(),
        ], 500);
    }

    $data = $res->json() ?? [];

    // buscar anos disponíveis (datas de todos os torneios)
    $yearsUrl = $base . '/rest/v1/torneios';
    $yearsQuery = 'select=' . rawurlencode('data_inicio') . '&limit=10000';

    $yearsRes = \Illuminate\Support\Facades\Http::withHeaders([
    'apikey' => $key,
    'Authorization' => 'Bearer ' . $key,
    'Accept' => 'application/json',
    ])->get($yearsUrl . '?' . $yearsQuery);

    $years = [];
    if ($yearsRes->ok()) {
    foreach (($yearsRes->json() ?? []) as $r) {
        $d = $r['data_inicio'] ?? null;
        if ($d && preg_match('/^\d{4}-\d{2}-\d{2}$/', $d)) {
        $years[(int)substr($d, 0, 4)] = true;
        }
    }
    }
    $years = array_keys($years);
    sort($years);


    // Pesquisa simples no backend (opcional) — nome/clube/categorias
    if ($q !== '') {
        $qq = mb_strtolower($q);
        $data = array_values(array_filter($data, function ($ev) use ($qq) {
            $cats = '';
            if (isset($ev['categorias']) && is_array($ev['categorias'])) {
                foreach ($ev['categorias'] as $c) {
                    $cats .= ' ' . ($c['codigo'] ?? '') . ' ' . ($c['nome'] ?? '');
                }
            }
            $hay = mb_strtolower(($ev['nome'] ?? '') . ' ' . ($ev['clube'] ?? '') . ' ' . $cats);
            return str_contains($hay, $qq);
        }));
    }

    $base = $url . '/storage/v1/object/public/';
    foreach ($data as &$ev) {
        $path = $ev['banner_path'] ?? null;
        $ev['banner_url'] = $path ? $path : null;

        $logo = $ev['clube_logo_path'] ?? null;
        $ev['clube_logo_url'] = $logo ? $logo : null;
    }
    unset($ev);

    // devolve
    return response()->json([
        'year' => $year,
        'years' => $years,
        'count' => count($data),
        'events' => $data,
    ]);
});

Route::get('/rankings', function (Request $request) {
    $map = [
        'M2' => 'https://manager.tiesports.com/rankings/d6072e66-d4f2-4b97-acf9-99508b322fa6',
        'M3' => 'https://manager.tiesports.com/rankings/68386d2e-a995-43ee-b596-b11652cf9b7c',
        'M4' => 'https://manager.tiesports.com/rankings/5c925745-41e8-47e9-8e78-739acaac1487',
        'M5' => 'https://manager.tiesports.com/rankings/cc3a4332-ec72-41a3-9dea-aa533e4f8d25',
        'M6' => 'https://manager.tiesports.com/rankings/4a75d617-144c-40db-84e3-6b98f4949df1',
        'F3' => 'https://manager.tiesports.com/rankings/5e172398-7f75-41c8-b26e-789088bf05b9',
        'F4' => 'https://manager.tiesports.com/rankings/ed590100-e27c-4be7-aa63-b7ec58c625f9',
        'F5' => 'https://manager.tiesports.com/rankings/51d8f950-2c54-48f5-ae83-c05b05e2212c',
        'F6' => 'https://manager.tiesports.com/rankings/dc1523da-91a2-4aaa-8f64-83b6f5f81558',
    ];

    $selected = strtoupper($request->query('cat', 'M2'));
    if (!isset($map[$selected])) $selected = 'M2';

    return view('rankings', [
        'map' => $map,
        'selected' => $selected,
        'url' => $map[$selected],
    ]);
});