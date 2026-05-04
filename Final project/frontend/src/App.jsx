import { useEffect, useState } from "react";

function App() {

  const [stores, setStores] = useState([]);
  const [storeName, setStoreName] = useState("");

  const [selectedStoreId, setSelectedStoreId] = useState(null);
  const [items, setItems] = useState([]);
  const [allItems, setAllItems] = useState([]);
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
    loadAllItemsOnList();
  }, []);

  function loadItemsInStore(storeId) {
  setSelectedStoreId(storeId);

  fetch(`${API}?path=items&store_id=${storeId}`)
    .then(res => res.json())
    .then(data => setItems(data));
}
  function loadAllItemsOnList() {
  fetch(`${API}?path=items`)
    .then(res => res.json())
    .then(data => setAllItems(data));
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
      loadAllItemsOnList();
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

      loadItemsInStore(selectedStoreId);
      loadAllItemsOnList();
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

function deleteItem(id) {
  fetch(`${API}?path=items&id=${id}`, {
    method: "DELETE"
  })
    .then(res => res.json())
    .then(data => {
      console.log(data);

      loadItemsInStore(selectedStoreId);
      loadAllItemsOnList();
    });
}
function toggleItemChecked(item) {
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

      loadItemsInStore(selectedStoreId);
      loadAllItemsOnList();
    });
}

function getStoreName(storeId) {
  const store = stores.find(s => s.id == storeId);
  return store ? store.name : "";
}

return (
  <div className="app">
    <h1>Shopping</h1>

    <div className="columns">

      <div className="panel">
        <h2>List</h2>

        {stores.map(store => {
          const checkedItems = allItems.filter(
            item => item.store_id == store.id && item.checked == 1
          );

          if (checkedItems.length === 0) return null;

          return (
            <div key={store.id}>
              <h3>{store.name}</h3>
              <p>{checkedItems.map(item => item.name).join(", ")}</p>
            </div>
          );
        })}
      </div>

      <div className="panel">
        <h2>Stores</h2>

        {stores.map(store => (
          <div key={store.id}>
            <h3 onClick={() => loadItemsInStore(store.id)}>
              {store.name}
            </h3>
          </div>
        ))}

        {selectedStoreId !== null && (
          <div>
            <h2>
              Items from {
                stores.find(store => store.id == selectedStoreId)?.name
              }
            </h2>

            {items.map(item => (
              <div key={item.id}>
                {item.name} - Qty: {item.quantity}

                <button onClick={() => toggleItemChecked(item)}>
                  {item.checked == 1 ? "Remove From List" : "Add To List"}
                </button>
              </div>
            ))}
          </div>
        )}
      </div>

      <div className="panel">
        <h2>Add / Remove</h2>

        <input
          type="text"
          value={storeName}
          onChange={(e) => setStoreName(e.target.value)}
          placeholder="Store name"
        />

        <button onClick={addStore}>
          Add Store
        </button>

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

        <h3>Delete Stores</h3>

        {stores.map(store => (
          <div key={store.id}>
            {store.name}

            <button onClick={() => deleteStore(store.id)}>
              Delete
            </button>
          </div>
        ))}

        <h3>Delete Items</h3>

        {items.map(item => (
          <div key={item.id}>
            {item.name}

            <button onClick={() => deleteItem(item.id)}>
              Remove
            </button>
          </div>
        ))}
      </div>

    </div>
  </div>
);
}

export default App;
