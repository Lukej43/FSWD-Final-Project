import { useEffect, useState } from "react";

function App() {

  const [stores, setStores] = useState([]);
  const [storeName, setStoreName] = useState("");

  function loadStores() {
    fetch("http://localhost/FinalProject/apiEndpoints.php?path=stores")
      .then(res => res.json())
      .then(data => setStores(data));
  }

  useEffect(() => {
    loadStores();
  }, []);

  function addStore() {

    fetch("http://localhost/FinalProject/apiEndpoints.php?path=stores", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        name: storeName
      })
    })
    .then(() => {
      setStoreName("");
      loadStores();
    });
  }

  function deleteStore(id) {

    fetch(`http://localhost/FinalProject/apiEndpoints.php?path=stores&id=${id}`, {
      method: "DELETE"
    })
    .then(() => loadStores());
  }

  return (
    <div>

      <h1>Shopping Lists</h1>

      <input
        type="text"
        value={storeName}
        onChange={(e) => setStoreName(e.target.value)}
        placeholder="Store name"
      />

      <button onClick={addStore}>
        Add Store
      </button>

      {stores.map(store => (
        <div key={store.id}>

          <h2>{store.name}</h2>

          <button onClick={() => deleteStore(store.id)}>
            Delete
          </button>

        </div>
      ))}

    </div>
  );
}

export default App;