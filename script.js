// Function to fetch waiter call status from the server
function fetchWaiterCalls() {
    // Send a GET request to your server-side script that retrieves waiter calls
    fetch('get_waiter_calls.php')
        .then(response => response.json())
        .then(data => {
            // Clear the existing waiter call data
            document.getElementById('waiterCalls').innerHTML = '';

            // Process and display the waiter call data
            data.forEach(call => {
                const callElement = document.createElement('div');
                callElement.className = 'call';
                callElement.textContent = `Table ${call.table_number} called a waiter`;

                document.getElementById('waiterCalls').appendChild(callElement);
            });
        })
        .catch(error => console.error('Error:', error));
}

// Periodically fetch and display waiter call status
setInterval(fetchWaiterCalls, 5000); // Fetch every 5 seconds (adjust as needed)
