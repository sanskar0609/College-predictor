const apiUrl = 'https://raw.githubusercontent.com/nikhil25803/collegeAPI/main/data/engineering_ranking.json';

// Variables to store fetched data
let colleges = [];

// Fetch and display data
fetch(apiUrl)
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        colleges = data;
        displayColleges(colleges); // Display all colleges initially
    })
    .catch(error => console.error('Error fetching data:', error));

// Function to display colleges in a table
function displayColleges(collegesToDisplay) {
    const collegeList = document.querySelector('#college-list tbody');
    collegeList.innerHTML = ''; // Clear previous content

    collegesToDisplay.forEach(college => {
        const row = document.createElement('tr');

        row.innerHTML = `
            <td>${college.name}</td>
            <td>${college.city}</td>
            <td>${college.state}</td>
        `;

        collegeList.appendChild(row);
    });
}

// Filter functionality
document.getElementById('apply-filters').addEventListener('click', () => {
    const rankFilter = document.getElementById('filter-rank').value;
    const cityFilter = document.getElementById('filter-city').value.toLowerCase();
    const stateFilter = document.getElementById('filter-state').value.toLowerCase();

    const filteredColleges = colleges.filter(college => {
        const matchesRank = rankFilter ? college.rank == rankFilter : true;
        const matchesCity = cityFilter ? college.city.toLowerCase().includes(cityFilter) : true;
        const matchesState = stateFilter ? college.state.toLowerCase().includes(stateFilter) : true;
        return matchesRank && matchesCity && matchesState;
    });

    displayColleges(filteredColleges);
});

// Reset functionality
document.getElementById('reset-filters').addEventListener('click', () => {
    document.getElementById('filter-rank').value = '';
    document.getElementById('filter-city').value = '';
    document.getElementById('filter-state').value = '';
    displayColleges(colleges); // Reset to all colleges
});
