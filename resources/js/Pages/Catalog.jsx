import { useMemo, useState } from "react";
import AppLayout from "../Layouts/AppLayout";
import ProductCard from "../Components/ProductCard";

export default function Catalog({ products }) {
  const [q, setQ] = useState("");

  const filtered = useMemo(() => {
    const s = q.trim().toLowerCase();
    if (!s) return products;
    return products.filter((p) =>
      `${p.brand} ${p.name} ${p.tag ?? ""}`.toLowerCase().includes(s)
    );
  }, [q, products]);

  return (
    <AppLayout>
      <div style={{ display: "flex", alignItems: "center", justifyContent: "space-between", gap: 12, flexWrap: "wrap" }}>
        <h1 style={{ margin: 0 }}>Catálogo</h1>

        <input
          value={q}
          onChange={(e) => setQ(e.target.value)}
          placeholder="Buscar (ej: Afnan 9pm, Lattafa, Nicho...)"
          style={{ padding: 10, borderRadius: 12, border: "1px solid #ddd", width: 380, maxWidth: "100%", background: "#fff" }}
        />
      </div>

      <div style={{ marginTop: 10, opacity: 0.75 }}>
        Mostrando {filtered.length} de {products.length}
      </div>

      <div
        style={{
          marginTop: 16,
          display: "grid",
          gridTemplateColumns: "repeat(auto-fill, minmax(230px, 1fr))",
          gap: 14,
        }}
      >
        {filtered.map((p) => <ProductCard key={p.id} p={p} />)}
      </div>
    </AppLayout>
  );
}