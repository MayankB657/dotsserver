const addBtn = document.getElementById("add-btn");
const graphContainer = document.querySelector(".graph-container");

const graphDivInfo = [
    {
        filterName: "first-filter",
        graphShowId: "failed-login-attempt-graph",
        Title: " Failed Login Attempts Over Time",
        canvaId: "failed-login-attempt-chart",
        bottomInfo: "This graph shows the number of failed login attempts across different time periods."

    },
    {
        filterName: "second-filter",
        graphShowId: "attempt-graph",
        Title: "hello Over Time",
        canvaId: "failed-login-attemp",
        bottomInfo: " shows the number of failed login attempts across different time periods."

    }, {
        filterName: "third-filter",
        graphShowId: "graph",
        Title: "Hello",
        canvaId: "failed-login",
        bottomInfo: "failed login attempts across different time periods."

    }
]

let currentGraphIndex = 0;
const maxGraphs = 9; 

addBtn.addEventListener("click", function () {
    if (currentGraphIndex < graphDivInfo.length && currentGraphIndex < maxGraphs) {
        const e = graphDivInfo[currentGraphIndex]; // Get the current graph info

        // Create a new div element
        const newDiv = document.createElement("div");

        // Add the graph layout for this filter
        newDiv.classList.add("graph-div", "p-4", "w-full");
        newDiv.innerHTML += ` <div class="${e.filterName} flex items-center gap-2 flex-wrap">
                          <div class="activity-dropdown inline-block relative">
                                <button
                                  class="activity-btn rounded px-6 py-1 custom-outline custom-safety-btn"
                                >
                                  <span>Activity Type</span>
                                  <i class="ri-arrow-down-s-fill"></i>
                                </button>
                                <ul
                                  class="activity-dropdown-menu activity-custom-dropdown-menu absolute hidden text-c-black shadow bg-custom-pure-white text-xs"
                                >
                                  <li id="user" class="activity-item user-activity">
                                    <a
                                      class="custom-bg-hover rounded-t py-2 px-4 block whitespace-no-wrap px-4"
                                      href="#"
                                      >User Activity</a
                                    >
                                  </li>
                                  <li id="group" class="dropdown-submenu group activity-item group-activity">
                                    <a
                                      class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                      href="#"
                                    >
                                      Group Activity
                                    </a>
                                  </li>
                                  <li id="rbac" class="dropdown-submenu group activity-item rbac-activity">
                                    <a
                                      class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                      href="#"
                                    >
                                      RBAC
                                    </a>
                                  </li>
                                  <li id="filemanagement" class="dropdown-submenu group activity-item filemanagement-activity">
                                    <a
                                      class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                      href="#"
                                    >
                                      File management 
                                    </a>
                                  </li>
                                  <li id="softwareusage" class="dropdown-submenu group activity-item softwareusage-activity">
                                    <a
                                      class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                      href="#"
                                    >
                                      Software Usage
                                    </a>
                                  </li>
                                  <li id="locationbased" class="dropdown-submenu group activity-item locationbased-activity">
                                    <a
                                      class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                      href="#"
                                    >
                                      Location-Based Metrics 
                                    </a>
                                  </li>
                                  <li id="systemperformance" class="dropdown-submenu group activity-item systemperformance-activity">
                                    <a
                                      class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                      href="#"
                                    >
                                      System Performance 
                                    </a>
                                  </li>
                                  <li id="security" class="dropdown-submenu group activity-item security-activity">
                                    <a
                                      class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                      href="#"
                                    >
                                      Security
                                    </a>
                                  </li>
                                  <li id="auditlogs" class="dropdown-submenu group activity-item auditlogs-activity">
                                    <a
                                      class="rounded-b custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                      href="#"
                                    >
                                      Audit Logs
                                    </a>
                                  </li>
                                </ul>
                          </div>
                           <div class="graph-dropdown inline-block relative">
                                <button
                                  class="select-graph rounded px-6 py-1 custom-outline custom-safety-btn user"
                                >
                                  <span>Select Graph</span>
                                  <i class="ri-arrow-down-s-fill"></i>
                                </button>
                                 <ul
                                  class="user-activity-menu graph-dropdown-menu graph-custom-dropdown-menu absolute hidden text-c-black shadow bg-custom-pure-white text-xs"
                                >
                                  <li id="user-login-over-time">
                                    <a
                                      class="custom-bg-hover rounded-t py-2 px-4 block whitespace-no-wrap px-4"
                                      href="#"
                                      >User Logins Over Time</a
                                    >
                                  </li>
                                  <li id="failed-login-attempt" class="dropdown-submenu group">
                                    <a
                                      class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                      href="#"
                                    >
                                      Failed Login Attempts
                                    </a>
                                  </li>
                                  <li id="successful-logout" class="dropdown-submenu group">
                                    <a
                                      class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                      href="#"
                                    >
                                      Successful Logouts
                                    </a>
                                  </li>
                                  <li class="dropdown-submenu group">
                                    <a
                                      class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                      href="#"
                                    >
                                      Average Session Duration per User
                                    </a>
                                  </li>
                                  <li class="dropdown-submenu group">
                                    <a
                                      class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                      href="#"
                                    >
                                      Most Active Users
                                    </a>
                                  </li>
                                  <li class="dropdown-submenu group">
                                    <a
                                      class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                      href="#"
                                    >
                                      Inactive Users
                                    </a>
                                  </li>
                                  <li class="dropdown-submenu group">
                                    <a
                                      class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                      href="#"
                                    >
                                      File Accessed by Users 
                                    </a>
                                  </li>
                                  <li class="dropdown-submenu group">
                                    <a
                                      class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                      href="#"
                                    >
                                    Files Downloaded by Users
                                    </a>
                                  </li>
                                  <li class="dropdown-submenu group">
                                    <a
                                      class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                      href="#"
                                    >
                                    Files Uploaded by Users
                                    </a>
                                  </li>
                                  <li class="dropdown-submenu group">
                                    <a
                                      class="rounded-b custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                      href="#"
                                    >
                                      File Types Accessed
                                    </a>
                                  </li>
                                </ul>
                                  <ul
                                  class="group-activity-menu graph-dropdown-menu graph-custom-dropdown-menu absolute hidden text-c-black shadow bg-custom-pure-white text-xs"
                                >
                                  <li>
                                    <a
                                      class="custom-bg-hover rounded-t py-2 px-4 block whitespace-no-wrap px-4"
                                      href="#"
                                      >Groups Created Over Time</a
                                    >
                                  </li>
                                  <li class="dropdown-submenu group">
                                    <a
                                      class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                      href="#"
                                    >
                                      Group Activity Distribution
                                    </a>
                                  </li>
                                  <li class="dropdown-submenu group">
                                    <a
                                      class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                      href="#"
                                    >
                                      Group File Access Patterns
                                    </a>
                                  </li>
                                  <li class="dropdown-submenu group">
                                    <a
                                      class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                      href="#"
                                    >
                                    Number of Users in Groups
                                    </a>
                                  </li>
                                  <li class="dropdown-submenu group">
                                    <a
                                      class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                      href="#"
                                    >
                                    Group Participation by Location
                                    </a>
                                  </li>
                                  <li class="dropdown-submenu group">
                                    <a
                                      class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                      href="#"
                                    >
                                    File Sharing Between Groups
                                    </a>
                                  </li>
                                  <li class="dropdown-submenu group">
                                    <a
                                      class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                      href="#"
                                    >
                                    External API Access by Groups
                                    </a>
                                  </li>
                                  <li class="dropdown-submenu group">
                                    <a
                                      class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                      href="#"
                                    >
                                    Collaboration Patterns in Groups
                                    </a>
                                  </li>
                                  <li class="dropdown-submenu group">
                                    <a
                                      class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                      href="#"
                                    >
                                  Inactive Groups
                                    </a>
                                  </li>
                                  <li class="dropdown-submenu group">
                                    <a
                                      class="rounded-b custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                      href="#"
                                    >
                                    Group Ownership Changes
                                    </a>
                                  </li>
                                </ul>
                                <ul
                                class="rbac-activity-menu graph-dropdown-menu graph-custom-dropdown-menu absolute hidden text-c-black shadow bg-custom-pure-white text-xs"
                              >
                                <li>
                                  <a
                                    class="custom-bg-hover rounded-t py-2 px-4 block whitespace-no-wrap px-4"
                                    href="#"
                                    >Roles Created Over Time</a
                                  >
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                    Permission Changes by Roles
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                    Privileges Per Role
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  Role Usage by Time
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  Users Assigned to Roles
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                 Files Accessed by Role
                                  </a>
                                </li>
                              </ul>
                               <ul
                                class="filemanagement-activity-menu graph-dropdown-menu graph-custom-dropdown-menu absolute hidden text-c-black shadow bg-custom-pure-white text-xs"
                              >
                                <li>
                                  <a
                                    class="custom-bg-hover rounded-t py-2 px-4 block whitespace-no-wrap px-4"
                                    href="#"
                                    >Files Accessed Over Time</a
                                  >
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                    Most Accessed Files
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                    Average File Access Time
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  File Modifications
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  Deleted Files Over Time
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  File Access by Location
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  Unauthorized File Access
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  Large File Transfers
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                Sensitive File Access
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="rounded-b custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  Files Accessed Outside Business Hours
                                  </a>
                                </li>
                              </ul>
                               <ul
                                class="softwareusage-activity-menu graph-dropdown-menu graph-custom-dropdown-menu absolute hidden text-c-black shadow bg-custom-pure-white text-xs"
                              >
                                <li>
                                  <a
                                    class="custom-bg-hover rounded-t py-2 px-4 block whitespace-no-wrap px-4"
                                    href="#"
                                    >Software Installations</a
                                  >
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                    Software Engagement by Users
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                    Version Updates Over Time
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  Software Crashes
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  Software Usage Patterns by Users
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  License Expirations
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  Software Used in Multiple Locations
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  Software Vulnerabilities Exploited
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                Software Access Frequency
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="rounded-b custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  Error Rates by Software
                                  </a>
                                </li>
                              </ul>
                              <ul
                                class="locationbased-activity-menu graph-dropdown-menu graph-custom-dropdown-menu absolute hidden text-c-black shadow bg-custom-pure-white text-xs"
                              >
                                <li>
                                  <a
                                    class="custom-bg-hover rounded-t py-2 px-4 block whitespace-no-wrap px-4"
                                    href="#"
                                    >User Access by Country</a
                                  >
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                    Latency by Location
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                    File Access by Country
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  Failed File Transfers by Location
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  Bandwidth Utilization by Location
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  User Activity Patterns by Country
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  File Sharing Between Countries
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  Data Transfer Rates by Region
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                Network Latency by Time Zone
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="rounded-b custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  Access from Unusual Locations
                                  </a>
                                </li>
                              </ul>
                              <ul
                                class="systemperformance-activity-menu graph-dropdown-menu graph-custom-dropdown-menu absolute hidden text-c-black shadow bg-custom-pure-white text-xs"
                              >
                                <li>
                                  <a
                                    class="custom-bg-hover rounded-t py-2 px-4 block whitespace-no-wrap px-4"
                                    href="#"
                                    >CPU Usage Over Time</a
                                  >
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                   RAM Usage Over Time
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                    Disk I/O Rates
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  Network Traffic
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  Database Query Response Times
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  System Error Rates
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  System Uptime
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  Server Response Time by Location
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                I/O Wait Time Distribution
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="rounded-b custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  Resource Utilization per User
                                  </a>
                                </li>
                              </ul>
                              <ul
                                class="security-activity-menu graph-dropdown-menu graph-custom-dropdown-menu absolute hidden text-c-black shadow bg-custom-pure-white text-xs"
                              >
                                <li>
                                  <a
                                    class="custom-bg-hover rounded-t py-2 px-4 block whitespace-no-wrap px-4"
                                    href="#"
                                    >Security Incidents Over Time</a
                                  >
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                   Unauthorized Network Access
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                    Intrusion Detection Alerts
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  VPN Usage by Users
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  Failed File Encryption Attempts
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  Malware Infections
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                 Patches Applied Over Time
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  Firewall Block Events
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                Suspicious Activity in Logs
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="rounded-b custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  System Vulnerability Scans
                                  </a>
                                </li>
                              </ul>
                              <ul
                                class="auditlogs-activity-menu graph-dropdown-menu graph-custom-dropdown-menu absolute hidden text-c-black shadow bg-custom-pure-white text-xs"
                              >
                                <li>
                                  <a
                                    class="custom-bg-hover rounded-t py-2 px-4 block whitespace-no-wrap px-4"
                                    href="#"
                                    >File Access History</a
                                  >
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                   User Session History
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                    User Privilege Changes
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  Data Transfer Logs
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  Deleted Files Audit
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  Group Activity Logs
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                 Software Usage History
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  Role Assignment Changes
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                Unauthorized Access Logs
                                  </a>
                                </li>
                                <li class="dropdown-submenu group">
                                  <a
                                    class="rounded-b custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                    href="#"
                                  >
                                  System Backup Logs
                                  </a>
                                </li>
                              </ul>
                          </div>


                          <div class="data-label-dropdown inline-block relative ">
                                <button 
                                  class="label-btn rounded px-6 py-1 custom-outline custom-safety-btn"
                                >
                                  <span>Data Label</span>
                                  <i class="ri-arrow-down-s-fill"></i>
                                </button>
                                <ul
                                  class="label-dropdown-menu label-custom-dropdown-menu w-full absolute hidden text-c-black shadow bg-c-lighten-gray rounded overflow-hidden text-xs"
                                >
                                  <li id="on-label" class="activity-item">
                                    <a
                                      class="custom-bg-hover rounded-t py-2 px-4 block whitespace-no-wrap px-4"
                                      href="#"
                                      >On</a
                                    >
                                  </li>
                                  <li id="off-label" class="dropdown-submenu group activity-item">
                                    <a
                                      class="custom-bg-hover py-2 px-4 block whitespace-no-wrap flex justify-between items-center"
                                      href="#"
                                    >
                                      Off
                                    </a>
                                  </li>
                                </ul>
                          </div>
                          <button
                            class="custom-safety-btn rounded px-6 py-1 mr-1 hover:border-yellow-300"
                          >
                            Today
                          </button>
                          <button
                            class="custom-safety-btn focus:border-yellow-500 rounded px-6 py-1 mr-1 hover:border-yellow-300"
                          >
                            Last 7 days
                          </button>
                          <button
                            class="custom-safety-btn rounded px-6 py-1 mr-1 hover:border-yellow-300"
                          >
                            Last 30 days
                          </button>
                          <button
                            class="custom-safety-btn rounded px-6 py-1 mr-1 hover:border-yellow-300"
                          >
                            Custom Date
                          </button>   
                      </div>
                       <div class="graph-area rounded mt-6">
                         <div class="pr-3 pt-4 flex gap-3 justify-end">
                            <i class="ri-eye-off-fill ri-lg" id="md-trigger"></i>
                            <i class="ri-eye-fill ri-lg hidden" id="md-close"></i>
                            <i class="ri-close-circle-fill ri-lg close-graph-div"></i>
                          </div>
                        <div class="graph-show hidden">
                          <div id="${e.graphShowId}">
                            <div class="text-c-black font-medium text-xl text-center py-3">
                             ${e.Title}
                            </div>
                              <div class="pt-2">
                                  <div style="height: 370px;">
                                      <canvas id="${e.canvaId}"></canvas>
                                  </div>
                              </div>
                              <div class="text-c-black font-normal text-lg text-center py-3">
                              ${e.bottomInfo}
                              </div>
                          </div>
                        </div>
                        <div class="flex justify-center items-center h-full suggestion">
                         <h1 class="text-4xl text-c-black">
                          Select Graph From Filter
                         </h1>
                        </div>
                      </div>`;

        // Append the new div to the graph container
        graphContainer.appendChild(newDiv);

       

        // Increment the current graph index to add the next graph on the next click
        currentGraphIndex++;
        if (currentGraphIndex === maxGraphs) {
            alert("Maximum graph limit reached.");
            addBtn.disabled = true; // Disable the Add button
        }
        const filterClass = `.${e.filterName}`;
        initializeDropdowns(filterClass);
    } else {
        console.log("All graphs have been added.");
    }
});
  


function initializeDropdowns(filterClass) {
    const activityBtn = document.querySelectorAll(`${filterClass} .activity-btn`);
    const activityDropdownMenu = document.querySelectorAll(`${filterClass} .activity-dropdown-menu`);
    const selectGraphButton = document.querySelectorAll(`${filterClass} .select-graph`);
    const graphDropdownMenus = {
        user: document.querySelector(`${filterClass} .user-activity-menu`),
        group: document.querySelector(`${filterClass} .group-activity-menu`),
        rbac: document.querySelector(`${filterClass} .rbac-activity-menu`),
        filemanagement: document.querySelector(`${filterClass} .filemanagement-activity-menu`),
        softwareusage: document.querySelector(`${filterClass} .softwareusage-activity-menu`),
        locationbased: document.querySelector(`${filterClass} .locationbased-activity-menu`),
        systemperformance: document.querySelector(`${filterClass} .systemperformance-activity-menu`),
        security: document.querySelector(`${filterClass} .security-activity-menu`),
        auditlogs: document.querySelector(`${filterClass} .auditlogs-activity-menu`),
        
    };


    let selectedActivity = ''; // To keep track of the selected activity

    selectGraphButton.forEach(button => {
        button.disabled = true;
        button.classList.add('disabled-btn');
    });

    // Activity type dropdown toggle
    activityBtn.forEach((button, index) => {
        const menu = activityDropdownMenu[index];
        button.addEventListener('click', function (event) {
            event.stopPropagation();
            // Close other dropdowns
            activityDropdownMenu.forEach((otherMenu, otherIndex) => {
                if (otherIndex !== index) {
                    otherMenu.classList.add("hidden");
                }
            });
            // Toggle the current menu
            menu.classList.toggle("hidden");
        });
    });

    // Handle activity item selection
    document.querySelectorAll(`${filterClass} .activity-item`).forEach(function (item) {
        item.addEventListener('click', function (e) {
            e.stopPropagation(); // Prevent event propagation
            // Remove active class from all activity items
            document.querySelectorAll(`${filterClass} .activity-item`).forEach(el => el.classList.remove('bg-c-yellow'));
            // Add active class to the selected item
            item.classList.add('bg-c-yellow');
            // Get selected activity's ID
            selectedActivity = item.id;
            // Enable the Select Graph button
            selectGraphButton.forEach(button => {
                button.disabled = false;
                button.classList.remove('disabled-btn');
            });
            // Hide the activity dropdown after selection
            activityDropdownMenu.forEach(menu => menu.classList.add('hidden'));
            // Hide all graph dropdown menus
            Object.values(graphDropdownMenus).forEach(menu => {
                menu.classList.add("hidden");
            });
        });
    });

    // Handle Select Graph button click
    selectGraphButton.forEach(button => {
        button.addEventListener("click", function (event) {
            event.stopPropagation();
            if (!selectedActivity) return; // Do nothing if no activity is selected
            // Toggle the current graph menu based on the selected activity
            const currentGraphMenu = graphDropdownMenus[selectedActivity];
            if (currentGraphMenu) {
                const isVisible = !currentGraphMenu.classList.contains("hidden");
                Object.values(graphDropdownMenus).forEach(menu => {
                    menu.classList.add("hidden"); // Hide all graph menus
                });
                if (!isVisible) {
                    currentGraphMenu.classList.remove("hidden"); // Show the current menu if it was hidden
                }
            }
        });
    });


    // Close dropdowns when clicking outside
    document.addEventListener("click", function () {
        // Hide all activity dropdowns
        activityDropdownMenu.forEach(menu => {
            if (!menu.classList.contains("hidden")) {
                menu.classList.add("hidden");
            }
        });
        // Hide all graph dropdowns
        Object.values(graphDropdownMenus).forEach(menu => {
            if (!menu.classList.contains("hidden")) {
                menu.classList.add("hidden");
            }
        });
    });

    document.querySelector('.close-graph').addEventListener('click', function (e) {
            e.stopPropagation();

      document.querySelector(".graph-hidden-area").classList.add('hidden')
      document.querySelector(".suggestion").classList.remove("hidden")

        });

    document.querySelectorAll('.close-graph-div').forEach(function (closeBtn) {
        
        closeBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            
            // Hide the parent graph container
            closeBtn.closest(".graph-div").classList.add('hidden');

        });
    });

}

// Initialize dropdowns for each filter
initializeDropdowns('.default-filter');

