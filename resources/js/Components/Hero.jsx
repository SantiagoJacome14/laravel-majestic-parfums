import { Link } from "@inertiajs/react";

export default function Hero() {
  return (
    <div style={{
      backgroundImage: "url('/images/perfumes/hero.jpg')",
      backgroundSize: "cover",
      backgroundPosition: "center",
      height: "80vh",
      display: "flex",
      alignItems: "center",
      padding: "60px",
      color: "#fff"
    }}>
      <div style={{ maxWidth: 600 }}>
        
        <div style={{ color: "#d4af37", letterSpacing: 3 }}>
          COLECCIÓN EXCLUSIVA 2026
        </div>

        <h1 style={{ fontSize: 70, margin: "10px 0" }}>
          La Esencia de la
          <span style={{ color: "#d4af37" }}> Elegancia Árabe</span>
        </h1>

        <p style={{ opacity: 0.85, lineHeight: 1.6 }}>
          Descubra nuestra exclusiva selección de Perfumes Árabes,
          de Diseñador y de Nicho.
        </p>

        <div style={{ marginTop: 30, display: "flex", gap: 15 }}>
          <Link href="/catalog" style={{
            background: "#d4af37",
            color: "#000",
            padding: "14px 24px",
            borderRadius: 6,
            textDecoration: "none",
            fontWeight: "bold"
          }}>
            EXPLORAR COLECCIÓN
          </Link>

          <Link href="/catalog" style={{
            border: "1px solid rgba(255,255,255,0.4)",
            padding: "14px 24px",
            borderRadius: 6,
            textDecoration: "none",
            color: "#fff"
          }}>
            VER NOVEDADES
          </Link>
        </div>
      </div>
    </div>
  );
}