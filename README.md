# 💎 PB Progress Engine

This repository documents the architecture and team structure for the PB Progress Engine project. The core of the engine orchestrates two major operational zones: **Offense (STS)** and **Defense (LTS)**, each with its own technical stack, team, and aesthetic direction.

## Architecture Overview

```mermaid
graph TD
    Core[("💎 PB Progress Engine<br/>(Verslo Branduolys)")]
    subgraph STS_ZONE ["⚡ OFENSYVA (STS)"]
        M_IVE("📜 Mandatas:<br/>IVE-MEDIA-PROC-2025")
        subgraph TECH_OFF ["Technologinis Stack'as"]
            OS1["🐧 Kubuntu STS (Wayland)"]
            FW1["⚛️ SvelteKit / Qt QML"]
            Sec1["🛡️ AppArmor / Hibridinis"]
        end
        subgraph VISUAL_OFF ["Estetika"]
            V1["🌸 Visual Core:<br/>K-Pop / Anime (Rei)"]
        end
        subgraph TEAM_OFF ["Pilotai"]
            P1(Povilas Brilius)
            P2(Nerijus Rupšys)
        end
        M_IVE --> TECH_OFF
        M_IVE --> VISUAL_OFF
        M_IVE --> TEAM_OFF
    end
    subgraph LTS_ZONE ["🛡️ GYNYBA (LTS)"]
        M_LIZ("📜 Mandatas:<br/>LIZ-OFFICE-MGMT-2025")
        subgraph TECH_DEF ["Technologinis Stack'as"]
            OS2["🏢 RHEL/CentOS (X11)"]
            FW2["🐘 Legacy MVP / Qt Widgets"]
            Sec2["🔒 SELINUX (Griežtas)"]
        end
        subgraph VISUAL_DEF ["Estetika"]
            V2["👔 Visual Core:<br/>Legacy Corporate"]
        end
        subgraph TEAM_DEF ["Saugotojai"]
            D1(Oliver SellerX)
            D2(Henrik AcquireY)
            D3(Juozas Rupšys)
        end
        M_LIZ --> TECH_DEF
        M_LIZ --> VISUAL_DEF
        M_LIZ --> TEAM_DEF
    end
    Core ==> M_IVE
    Core ==> M_LIZ
    class M_IVE,OS1,FW1,Sec1,V1,P1,P2 offense;
    class M_LIZ,OS2,FW2,Sec2,V2,D1,D2,D3 defense;
```

---

## 🏛️ Core

The **PB Progress Engine** ("Verslo Branduolys") forms the central foundation for two functional spheres:

- **STS (Ofensyva)** — Fast-moving, innovative, pilot-oriented operations.
- **LTS (Gynyba)** — Stable, legacy-focused, defender-oriented management.

---

## ⚡ OFENSYVA (STS ZONE)

- **Mandate:** `IVE-MEDIA-PROC-2025`
- **Tech Stack:**
  - 🐧 Kubuntu STS (Wayland)
  - ⚛️ SvelteKit / Qt QML
  - 🛡️ AppArmor / Hybrid Security
- **Visual Core:** 🌸 K-Pop / Anime (Rei)
- **Team ("Pilotai"):**
  - Povilas Brilius
  - Nerijus Rupšys

---

## 🛡️ GYNYBA (LTS ZONE)

- **Mandate:** `LIZ-OFFICE-MGMT-2025`
- **Tech Stack:**
  - 🏢 RHEL/CentOS (X11)
  - 🐘 Legacy MVP / Qt Widgets
  - 🔒 SELINUX (Strict)
- **Visual Core:** 👔 Legacy Corporate
- **Team ("Saugotojai"):**
  - Oliver SellerX
  - Henrik AcquireY
  - Juozas Rupšys

---

## Credits

Diagram & structure based on [PB.mmd](./PB.mmd).
