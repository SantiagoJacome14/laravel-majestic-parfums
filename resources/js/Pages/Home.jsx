import AppLayout from "../Layouts/AppLayout";
import Hero from "../Components/Hero";
import { Link } from "@inertiajs/react";

export default function Home() {
  return (
    <AppLayout>

      {/* HERO */}
      <Hero />

      {/* CONTENIDO */}
      <div style={{ display: "grid", gap: 16, marginTop: 40 }}>

        <div style={{ background: "#fff", border: "1px solid #eee", borderRadius: 16, padding: 18 }}>
          <h1 style={{ margin: 0, fontSize: 34 }}>Perfumes 100% originales ✨</h1>

          <p style={{ marginTop: 10, opacity: 0.8, lineHeight: 1.5 }}>
            Catálogo de perfumes árabes, diseñador y nicho. Envíos a todo Colombia.
          </p>

          <div style={{ display: "flex", gap: 12, marginTop: 14, flexWrap: "wrap" }}>
            <Link href="/catalog"
              style={{
                padding: "10px 14px",
                borderRadius: 12,
                border: "1px solid #111",
                background: "#111",
                color: "#fff",
                textDecoration: "none"
              }}>
              Ver catálogo
            </Link>

            <Link href="/how-to-buy"
              style={{
                padding: "10px 14px",
                borderRadius: 12,
                border: "1px solid #eee",
                background: "#fff",
                textDecoration: "none"
              }}>
              Cómo comprar
            </Link>
          </div>
        </div>

        <div style={{
          display: "grid",
          gridTemplateColumns: "repeat(auto-fit, minmax(220px, 1fr))",
          gap: 12
        }}>
          {[
            { title: "Precios brutales", text: "Mejor precio del mercado en originales." },
            { title: "Asesoría", text: "Te recomiendo según tu gusto y edad." },
            { title: "Envíos rápidos", text: "Te compartimos guía y seguimiento." },
          ].map((c) => (
            <div key={c.title}
              style={{
                background: "#fff",
                border: "1px solid #eee",
                borderRadius: 16,
                padding: 16
              }}>
              <div style={{ fontWeight: 900 }}>{c.title}</div>
              <div style={{ opacity: 0.75, marginTop: 6 }}>{c.text}</div>
            </div>
          ))}
        </div>

      </div>

    </AppLayout>
  );
}