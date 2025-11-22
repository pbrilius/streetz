<?php

/**
 * PB Progress Engine - Vanilla Seeder (FIXED)
 * -----------------------------------
 * Pataisyta: Įjungta 'ATTR_EMULATE_PREPARES', kad veiktų pasikartojantys parametrai.
 */

// 1. KONFIGŪRACIJA
$host = "localhost";
$db = "stem";
$user = "padėjėjas"; // Jūsų vartotojas
$pass = "puxeyusawulojosu"; // Jūsų slaptažodis
$charset = "utf8mb4";

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // PAKEITIMAS ČIA: Turi būti true, kad veiktų 'ON DUPLICATE KEY UPDATE' su tais pačiais parametrais
    PDO::ATTR_EMULATE_PREPARES => true,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "[INIT] Prisijungta prie duomenų bazės sėkmingai.\n";
} catch (\PDOException $e) {
    die("[ERROR] Nepavyko prisijungti: " . $e->getMessage() . "\n");
}

try {
    // Išjungiame FK patikras laikinai
    $pdo->exec("SET FOREIGN_KEY_CHECKS=0");

    // ---------------------------------------------------------
    // 2. STRATEGIJOS
    // ---------------------------------------------------------
    echo "[PROCESS] Diegiamos strategijos...\n";

    $sqlStrategy = "INSERT INTO strategijos_tipai (strategijos_id, aprasymas, palaikymo_filosofija)
                    VALUES (:id, :desc, :phil)
                    ON DUPLICATE KEY UPDATE aprasymas=:desc, palaikymo_filosofija=:phil";

    $stmtStr = $pdo->prepare($sqlStrategy);

    $strategies = [
        [
            "id" => "GYNYBA_LTS",
            "desc" =>
                "Stabilumas, ilgalaikis palaikymas ir žemi TCO. (ExpressVPN)",
            "phil" => "3-5 metų fiksuotas ciklas",
        ],
        [
            "id" => "OFENSYVA_STS",
            "desc" =>
                "Maksimalus našumas, greitas TTM ir inovacijos. (Supreme/IVE)",
            "phil" => "9 mėnesių rizikos ciklas",
        ],
    ];

    foreach ($strategies as $s) {
        $stmtStr->execute($s);
    }

    // ---------------------------------------------------------
    // 3. STANDARTAI
    // ---------------------------------------------------------
    echo "[PROCESS] Atnaujinami saugumo ir architektūros standartai...\n";

    // Saugumas
    $sqlSec = "INSERT INTO saugumo_standartai (saugumo_id, strategijos_id, mac_saugumas, duomenu_vientisumas)
               VALUES (:id, :strat, :mac, :data)
               ON DUPLICATE KEY UPDATE strategijos_id=:strat, mac_saugumas=:mac, duomenu_vientisumas=:data";
    $stmtSec = $pdo->prepare($sqlSec);

    $stmtSec->execute([
        "id" => 1,
        "strat" => "GYNYBA_LTS",
        "mac" => "SELINUX (RHEL/CentOS)",
        "data" => "Doctrine ORM / UUID",
    ]);
    $stmtSec->execute([
        "id" => 2,
        "strat" => "OFENSYVA_STS",
        "mac" => "AppArmor / Hibridinis",
        "data" => "MVVM (SvelteKit) / Duomenų Binding",
    ]);

    // Architektūra
    $sqlArch = "INSERT INTO architekturos_standartai (arch_id, strategijos_id, os_standartas, frontend_karkasas)
                VALUES (:id, :strat, :os, :front)
                ON DUPLICATE KEY UPDATE strategijos_id=:strat, os_standartas=:os, frontend_karkasas=:front";
    $stmtArch = $pdo->prepare($sqlArch);

    $stmtArch->execute([
        "id" => 1,
        "strat" => "GYNYBA_LTS",
        "os" => "DEB/RPM LTS",
        "front" => "MVP (Legacy) / Qt Widgets",
    ]);
    $stmtArch->execute([
        "id" => 2,
        "strat" => "OFENSYVA_STS",
        "os" => "Kubuntu STS (Wayland/Qt 6)",
        "front" => "MVVM (SvelteKit) / Qt QML",
    ]);

    // ---------------------------------------------------------
    // 4. MANDATAI
    // ---------------------------------------------------------
    echo "[PROCESS] Registruojami IVE ir LIZ mandatai...\n";

    $sqlMandate = "INSERT INTO strategijos_mandatas (mandato_id, strategijos_id, saugumo_tipas_fk, architekturos_tipas_fk, verslo_rezultatas, kritinis_ispejimas)
                   VALUES (:id, :strat, :sec, :arch, :res, :warn)
                   ON DUPLICATE KEY UPDATE strategijos_id=:strat, saugumo_tipas_fk=:sec, architekturos_tipas_fk=:arch, verslo_rezultatas=:res, kritinis_ispejimas=:warn";
    $stmtMandate = $pdo->prepare($sqlMandate);

    $mandates = [
        [
            "id" => "IVE-MEDIA-PROC-2025",
            "strat" => "OFENSYVA_STS",
            "sec" => 2,
            "arch" => 2,
            "res" => "Maksimalus našumas / Greitas TTM",
            "warn" =>
                "Rizika: Priimtas 9 mėnesių atnaujinimo ciklas. Būtinas IVE vizualinis kodas.",
        ],
        [
            "id" => "LIZ-OFFICE-MGMT-2025",
            "strat" => "GYNYBA_LTS",
            "sec" => 1,
            "arch" => 1,
            "res" => "Minimalūs TCO / Stabilumas kritiniams procesams",
            "warn" =>
                "Mandatas: ExpressVPN (LTS) būtinas. Saugumo sistemos (SELINUX) privalomos.",
        ],
    ];

    foreach ($mandates as $m) {
        $stmtMandate->execute($m);
    }

    // ---------------------------------------------------------
    // 5. DARBUOTOJŲ PATCHING
    // ---------------------------------------------------------
    echo "[PROCESS] Vykdomas darbuotojų profilių auditavimas...\n";

    $stmtGet = $pdo->query(
        "SELECT id, full_name, role_id, attributes FROM employees",
    );
    $employees = $stmtGet->fetchAll();

    $stmtUpdate = $pdo->prepare(
        "UPDATE employees SET attributes = :attr WHERE id = :id",
    );

    foreach ($employees as $emp) {
        $attr = json_decode($emp["attributes"], true) ?? [];
        $name = strtolower($emp["full_name"]);

        $isDev =
            strpos($name, "povilas") !== false ||
            strpos($name, "nerijus") !== false ||
            $emp["role_id"] == 8;

        if ($isDev) {
            $attr["Active_Mandate"] = "IVE-MEDIA-PROC-2025";
            $attr["Visual_Core"] = "K-Pop/Anime (Rei)";
            $attr["System_Mode"] = "Wayland/Hybrid";
            $status = "OFENSYVA (IVE)";
        } else {
            $attr["Active_Mandate"] = "LIZ-OFFICE-MGMT-2025";
            $attr["Visual_Core"] = "Legacy Corporate";
            $attr["System_Mode"] = "X11/Stable";
            $status = "GYNYBA (LIZ)";
        }

        $stmtUpdate->execute([
            "attr" => json_encode(
                $attr,
                JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT,
            ),
            "id" => $emp["id"],
        ]);

        echo "   -> Atnaujintas: {$emp["full_name"]} [$status]\n";
    }

    $pdo->exec("SET FOREIGN_KEY_CHECKS=1");
    echo "[SUCCESS] Pažangos variklis sėkmingai perkrautas 'Vanilla' režimu.\n";
} catch (\PDOException $e) {
    echo "[FAIL] Klaida: " . $e->getMessage();
}
