import { Link } from "@inertiajs/react";

export default function AppLayout({ children }) {
  return (
    <div style={{ background: "#0b0b0b", minHeight: "100vh", color: "#fff" }}>
      
      {/* NAVBAR */}
      <header style={{ borderBottom: "1px solid rgba(255,255,255,0.08)" }}>
        <div style={{
          maxWidth: 1300,
          margin: "0 auto",
          padding: "16px 20px",
          display: "flex",
          alignItems: "center",
          justifyContent: "space-between"
        }}>
          
          {/* LOGO */}
          <Link href="/" style={{
            textDecoration: "none",
            color: "#d4af37",
            fontWeight: "800",
            letterSpacing: 2,
            fontSize: 20
          }}>
            MAJESTIC PARFUMS
          </Link>

          {/* MENU */}
          <nav style={{ display: "flex", gap: 26, fontSize: 14 }}>
            <Link href="/catalog?tag=Árabe">ÁRABES</Link>
            <Link href="/catalog?tag=Diseñador">DISEÑADOR</Link>
            <Link href="/catalog?tag=Nicho">NICHO</Link>
            <Link href="/catalog">NOVEDADES</Link>
          </nav>

          {/* SEARCH */}
          <input
            placeholder="Buscar fragancias..."
            style={{
              padding: "8px 14px",
              borderRadius: 30,
              border: "1px solid rgba(255,255,255,0.2)",
              background: "transparent",
              color: "#fff",
              width: 220
            }}
          />

        </div>
      </header>

      {/* CONTENT */}
      <main>{children}</main>

      {/* WHATSAPP FLOAT */}
      <a
        href="https://wa.me/573183221806?text=Hola%20Majestic%20Parfums!%20Estoy%20interesado%20en%20sus%20fragancias.%20¿Podrían%20ayudarme%3F"
        target="_blank"
        style={{
          position: "fixed",
          bottom: 20,
          right: 20,
          background: "#25D366",
          width: 60,
          height: 60,
          borderRadius: "50%",
          display: "flex",
          alignItems: "center",
          justifyContent: "center",
          color: "#fff",
          fontSize: 28,
          textDecoration: "none",
          boxShadow: "0 10px 30px rgba(0,0,0,0.4)"
        }}
      >
        💬
      </a>

    </div>
  );
}