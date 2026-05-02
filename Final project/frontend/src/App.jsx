import { useEffect, useState } from "react";

function App() {

  const [stores, setStores] = useState([]);
  const [storeName, setStoreName] = useState("");

  const [selectedStoreId, setSelectedStoreId] = useState(null);
  const [items, setItems] = useState([]);
  const [itemName, setItemName] = useState("");
  const [quantity, setQuantity] = useState(1);

  const API = "http://localhost/Final%20project/apiEndpoints.php";

  function loadStores() {
    fetch(`${API}?path=store`)
      .then(res => res.json())
      .then(data => setStores(data));
  }

  useEffect(() => {
    loadStores();
  }, []);

  function loadItems(storeId) {
  setSelectedStoreId(storeId);

  fetch(`${API}?path=items&store_id=${storeId}`)
    .then(res => res.json())
    .then(data => setItems(data));
}

function addStore() {
  console.log("hit");

  fetch(`${API}?path=store`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({
      name: storeName
    })
  })
    .then(res => res.json())
    .then(data => {
      console.log(data);

      setStoreName("");
      loadStores();
    });
}

function addItem() {
  fetch(`${API}?path=items`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({
      store_id: selectedStoreId,
      name: itemName,
      quantity: quantity
    })
  })
    .then(res => res.json())
    .then(data => {
      console.log(data);

      setItemName("");
      setQuantity(1);

      loadItems(selectedStoreId);
    });
}

  function deleteStore(id) {

  fetch(`${API}?path=store&id=${id}`, {
    method: "DELETE"
  })
    .then(res => res.json())
    .then(data => {

      console.log(data);

      loadStores();
    });
}

function deleteItem(id){

    fetch(`${API}?path=items&id=${id}`, {
      method: "DELETE"
  })
    .then(res => res.json())
    .then(data => {

      console.log(data);

      loadItems();
    });
}
function addItemToList(item) {
  fetch(`${API}?path=items&id=${item.id}`, {
    method: "PUT",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({
      checked: item.checked == 1 ? 0 : 1,
      name: item.name,
      quantity: item.quantity
    })
  })
    .then(res => res.json())
    .then(data => {
      console.log(data);
      loadItems(selectedStoreId);
    });
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

          <h2 onClick={() => loadItems(store.id)}>
            {store.name}
          </h2>

          <button onClick={() => deleteStore(store.id)}>
          Delete
          </button>

        </div>
      ))}
      {selectedStoreId && (
  <div>

    <h2>Items</h2>

    <input
      type="text"
      value={itemName}
      onChange={(e) => setItemName(e.target.value)}
      placeholder="Item name"
    />

    <input
      type="number"
      value={quantity}
      onChange={(e) => setQuantity(e.target.value)}
      min="1"
    />

    <button onClick={addItem}>
      Add Item
    </button>



    {items.map(item => (
      <div key={item.id}>f
        {item.name} - Qty: {item.quantity}
            <button onClick={() => deleteItem(item.id)}>
            delete Item
            </button>
            <button onClick={() => addItemToList(item)}>
          add to list
          </button>
      </div>
    ))}

  </div>
)}

    </div>
  );
}

export default App;