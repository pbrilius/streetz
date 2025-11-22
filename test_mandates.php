<?php

/**
 * PB Progress Engine - Integrity Unit Test
 * ----------------------------------------
 * Tikrina, ar OFENSYVA ir GYNYBA mandatai pritaikyti teisingai.
 * Naudojimas: php test_mandates.php
 */

// Spalvų kodai terminalui (estetikai)
const C_RESET = "\033[0m";
const C_RED = "\033[31m";
const C_GREEN = "\033[32m";
const C_BLUE = "\033[34m";
const C_BOLD = "\033[1m";

// Konfigūracija
$host = "localhost";
$db = "stem";
$user = "padėjėjas";
$pass = "puxeyusawulojosu";
$charset = "utf8mb4";

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

echo C_BOLD .
    "\n[TEST START] Pradedamas strateginio vientisumo auditas...\n" .
    C_RESET;
echo str_repeat("-", 50) . "\n";

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    // Gauname darbuotojus ir jų atributus
    $stmt = $pdo->query("SELECT full_name, role_id, attributes FROM employees");
    $employees = $stmt->fetchAll();

    $passed = 0;
    $failed = 0;

    foreach ($employees as $emp) {
        $attr = json_decode($emp["attributes"], true) ?? [];
        $name = $emp["full_name"];

        // Nustatome tikėtiną mandatą pagal logiką (Dev/Povilas/Nerijus = IVE, kiti = LIZ)
        $isOfensyva =
            strpos(strtolower($name), "povilas") !== false ||
            strpos(strtolower($name), "nerijus") !== false ||
            $emp["role_id"] == 8; // CDO

        $expectedMandate = $isOfensyva
            ? "IVE-MEDIA-PROC-2025"
            : "LIZ-OFFICE-MGMT-2025";
        $actualMandate = $attr["Active_Mandate"] ?? "NĖRA";

        // Tikrinimas
        if ($actualMandate === $expectedMandate) {
            $status = C_GREEN . "[PASS]" . C_RESET;
            $passed++;

            // Papildomas vizualinis patikrinimas Ofensyvai
            $extraInfo = "";
            if ($isOfensyva) {
                $visual = $attr["Visual_Core"] ?? "N/A";
                if (strpos($visual, "Rei") !== false) {
                    $extraInfo = " " . C_BLUE . "(Visual Core: OK)" . C_RESET;
                } else {
                    $extraInfo = " " . C_RED . "(Visual Core: FAIL)" . C_RESET;
                }
            }
        } else {
            $status = C_RED . "[FAIL]" . C_RESET;
            $failed++;
            $extraInfo = " (Tikėtasi: $expectedMandate, Rasta: $actualMandate)";
        }

        printf("%s %-20s %s\n", $status, $name, $extraInfo);
    }

    echo str_repeat("-", 50) . "\n";

    if ($failed === 0) {
        echo C_GREEN .
            C_BOLD .
            "REZULTATAS: VISOS SISTEMOS VEIKIA NOMINALIAI. 100% VIENTISUMAS." .
            C_RESET .
            "\n";
    } else {
        echo C_RED .
            C_BOLD .
            "REZULTATAS: RASTA $failed neatitikimų. Būtina korekcija." .
            C_RESET .
            "\n";
    }
} catch (\PDOException $e) {
    echo C_RED .
        "[CRITICAL ERROR] Nepavyko prisijungti: " .
        $e->getMessage() .
        C_RESET .
        "\n";
}
echo "\n";
