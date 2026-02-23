import { Link, useForm } from "@inertiajs/react";

export default function ProductCard({ p }) {
  const { post } = useForm({ product_id: p.id, qty: 1 });
  const img = p.image || "/images/placeholder.jpg";

  return (
    <div style={{ background: "#fff", border: "1px solid #eee", borderRadius: 16, padding: 12 }}>
      <Link href={`/product/${p.slug}`} style={{ textDecoration: "none", color: "inherit" }}>
        <img
          src={img}
          alt={`${p.brand} ${p.name}`}
          style={{ width: "100%", height: 230, objectFit: "cover", borderRadius: 12 }}
        />

        <div style={{ marginTop: 10 }}>
          <div style={{ fontSize: 12, opacity: 0.7 }}>{p.brand}</div>
          <div style={{ fontWeight: 900 }}>{p.name}</div>
          <div style={{ marginTop: 6, fontWeight: 900 }}>${p.price}</div>

          <div style={{ marginTop: 8, fontSize: 12, opacity: 0.75 }}>
            {p.tag ? `${p.tag} · ` : ""}{p.size || ""}{p.concentration ? ` · ${p.concentration}` : ""}
          </div>
        </div>
      </Link>

      <button
        onClick={() => post("/cart/add")}
        style={{
          marginTop: 12,
          width: "100%",
          padding: "10px 12px",
          borderRadius: 12,
          border: "1px solid #111",
          background: "#111",
          color: "#fff",
          cursor: "pointer",
          fontWeight: 800
        }}
      >
        Agregar al carrito
      </button>
    </div>
  );
}