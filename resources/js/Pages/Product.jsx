import AppLayout from "../Layouts/AppLayout";
import { Link, useForm } from "@inertiajs/react";

export default function Product({ product }) {
  const { post, data, setData } = useForm({ product_id: product.id, qty: 1 });
  const img = product.image || "/images/placeholder.jpg";

  function add(e) {
    e.preventDefault();
    post("/cart/add");
  }

  return (
    <AppLayout>
      <Link href="/catalog">← Volver</Link>

      <div style={{ display: "grid", gridTemplateColumns: "1fr 1fr", gap: 22, marginTop: 16 }}>
        <img src={img} alt={`${product.brand} ${product.name}`} style={{ width: "100%", borderRadius: 16, objectFit: "cover" }} />

        <div style={{ background: "#fff", border: "1px solid #eee", borderRadius: 16, padding: 16 }}>
          <div style={{ opacity: 0.7 }}>{product.brand}</div>
          <h1 style={{ margin: "6px 0 0" }}>{product.name}</h1>

          <div style={{ marginTop: 12, fontSize: 22, fontWeight: 900 }}>${product.price}</div>

          <div style={{ marginTop: 12, opacity: 0.8, lineHeight: 1.6 }}>
            {product.tag ? <div>Tipo: {product.tag}</div> : null}
            {product.size ? <div>Tamaño: {product.size}</div> : null}
            {product.concentration ? <div>Concentración: {product.concentration}</div> : null}
          </div>

          <form onSubmit={add} style={{ marginTop: 16, display: "flex", gap: 10, alignItems: "center", flexWrap: "wrap" }}>
            <label>Cant:</label>
            <input
              type="number"
              min="1"
              max="99"
              value={data.qty}
              onChange={(e) => setData("qty", parseInt(e.target.value || "1"))}
              style={{ width: 90, padding: 10, borderRadius: 12, border: "1px solid #ddd" }}
            />
            <button type="submit" style={{ padding: "10px 14px", borderRadius: 12, border: "1px solid #111", background: "#111", color: "#fff", fontWeight: 800 }}>
              Agregar al carrito
            </button>
            <Link href="/cart" style={{ padding: "10px 14px", borderRadius: 12, border: "1px solid #eee" }}>
              Ver carrito
            </Link>
          </form>
        </div>
      </div>
    </AppLayout>
  );
}