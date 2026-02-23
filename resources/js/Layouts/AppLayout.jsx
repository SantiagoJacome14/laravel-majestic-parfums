import { Link } from "@inertiajs/react";

export default function AppLayout({ children }) {
  return (
    <div style={{ minHeight: "100vh", background: "#fafafa" }}>
      <header style={{ background: "#fff", borderBottom: "1px solid #eee" }}>
        <div style={{ maxWidth: 1200, margin: "0 auto", padding: "14px 16px", display: "flex", justifyContent: "space-between", alignItems: "center" }}>
          <Link href="/" style={{ textDecoration: "none", color: "#111", fontWeight: 900, fontSize: 18 }}>
            Majestic Parfums
          </Link>

          <nav style={{ display: "flex", gap: 14, alignItems: "center" }}>
            <Link href="/catalog">Catálogo</Link>
            <Link href="/cart">Carrito</Link>
            <Link href="/how-to-buy">Cómo comprar</Link>
          </nav>
        </div>
      </header>

      <main style={{ maxWidth: 1200, margin: "0 auto", padding: "18px 16px" }}>
        {children}
      </main>

      <footer style={{ borderTop: "1px solid #eee", marginTop: 26, padding: 18, background: "#fff" }}>
        <div style={{ maxWidth: 1200, margin: "0 auto", padding: "0 16px", opacity: 0.7 }}>
          © {new Date().getFullYear()} Majestic Parfums · 100% Original
        </div>
      </footer>
    </div>
  );
}