<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Light App</title>
    <link href="https://unpkg.com/tailwindcss@^2.2.19/dist/tailwind.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'].'lightapp.css') }}" />
  </head>
  <body>

    <div class="lightapp w-full h-screen">
      <div class="lightapp-container w-full flex">
        <div class="lightapp-sidebar h-full w-1/4 md:1/4 lg:w-1/6 bg-no-repeat bg-cover bg-center">
          <div class="lightapp-logo px-9 py-7">
            <img class="w-16 h-16" src="{{ asset($constants['IMAGEFILEPATH'].'logo.png')}}" alt="logo" />
          </div>
          <nav>
            @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
                 <?php
// Assuming $app is an array of objects
$dataArray = [];
foreach ($app as $data) {

    $dataArray[] = [
        "id" => @$data->id,
        "name" => @$data->name,
        "image" => @$data->picture_icon // Assuming image is fixed for all; modify as necessary
    ];
}

    // dump($dataArray);


// JSON encode the PHP array
$jsonData = json_encode($dataArray);
?>
            <ul class="grid gap-2">
              <li>
                <a class="flex items-center gap-3 rounded-r-md py-3 bg-black text-sm hover:bg-black" href="{{url('list')}}">
                  <span id="All" class="text-base font-normal px-10">All</span>
                </a>
              </li>
              <li>
                <a class="flex items-center gap-3 rounded-r-md py-3 text-sm hover:bg-black"  href="{{url('app_role_list/Tool')}}">
                  <span class="text-base font-normal px-10"> Tool </span>
                </a>
              </li>
              <li>
                <a class="flex items-center gap-3 rounded-r-md py-3 text-sm transition-colors hover:bg-black" href="{{url('app_role_list/Game')}}" >
                  <span class="text-base font-normal px-10"> Game </span>
                </a>
              </li>
              <li>
                <a class="flex items-center gap-3 rounded-r-md py-3 text-sm ransition-colors hover:bg-black" href="{{url('app_role_list/Movie')}}">
                  <span class="text-base font-normal px-10"> Movie </span>
                </a>
              </li>
              <li>
                <a class="flex items-center gap-3 rounded-r-md py-3 text-sm transition-colors hover:bg-black" href="{{url('app_role_list/Music')}}">
                  <span class="text-base font-normal px-10"> Music </span>
                </a>
              </li>
              <li>
                <a class="flex items-center gap-3 rounded-r-md py-3 text-sm transition-colors hover:bg-black" href="{{url('app_role_list/Life')}}">
                  <span class="text-base font-normal px-10"> Life </span>
                </a>
              </li>
              <li>
                <a class="flex items-center gap-3 rounded-r-md py-3 text-sm transition-colors hover:bg-black" href="{{url('app_role_list/Others')}}">
                  <span class="text-base font-normal px-10"> Others </span>
                </a>
              </li>
            </ul>
          </nav>
        </div>
        <div class="right-container h-full w-3/4 md:3/4 lg:w-5/6 bg-no-repeat bg-cover" >
          <div class="lightapp-header w-full h-28">
            <div class="flex items-center gap-2 py-3 px-6">
              <img class="w-10 h-10" src="{{ asset($constants['IMAGEFILEPATH'].'lightimg.png')}}" alt="Light Image"/>
              <h1 class="text-base font-normal mb-2">Light App</h1>
            </div>
            <div class="lightapp-yellowbar w-full h-12 bg-no-repeat bg-cover bg-center flex items-center justify-between px-7" >
              <span class="text-base font-medium">All</span>
              <span>
                <button data-modal-target="Create-modal" data-modal-toggle="Create-modal" class="lightapp-btn py-2 px-6 bg-black text-sm rounded-sm" >
                  Create a light application
                </button>
              </span>
            </div>
          </div>
          <div class="lightapp-content flex gap-10 flex-wrap p-5">
            <div id="Create-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full" >
              <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-xl shadow dark:bg-gray-700" >
                  <div class="flex items-center gap-4 p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <div class="img-container w-18 h-18 rounded-lg bg-white shadow-black flex items-center justify-center" >
                      <img class="w-16 h-16" src="{{ asset($constants['IMAGEFILEPATH'].'lightimg.png')}}" alt="Light image" />
                    </div>
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                      Create a light application
                    </h3>
                  </div>
                  <div class="p-4 md:p-5 space-y-4">
<form class="space-y-4" action="{{url('submit')}}" method="POST" enctype="multipart/form-data">
  @csrf
  <div class="flex items-center">
    <div class="w-1/3">
      <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name:<span class="text-red-500">*</span></label>
    </div>
    <div class="w-2/3">
      <input
        type="text"
        name="name"
        id="name"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
        placeholder="Please enter an application name"
        required
      />
    </div>
  </div>
  <div class="flex items-center">
    <div class="w-1/3">
      <label
        for="website-link"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
        >Website link:<span class="text-red-500">*</span></label>
    </div>
    <div class="w-2/3">
      <input
        type="text"
        name="website_link"
        id="website-link"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
        placeholder="Please enter http / https link"
        required
      />
    </div>
  </div>
  <div class="flex items-center">
    <div class="w-1/3">
      <label
        for="app_group"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
        >Application grouping:<span class="text-red-500">*</span></label>
    </div>
    <div class="w-2/3">
      <select
        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg"
        name="app_group"
        id="app_group"
      >
        <option value="Tool">Tool</option>
        <option value="Game">Game</option>
        <option value="Movie">Movie</option>
        <option value="Music">Music</option>
        <option value="Life">Life</option>
        <option value="Others">Others</option>
      </select>
    </div>
  </div>
  <div class="flex items-center">
    <div class="w-1/3"></div>
    <div class="w-2/3">
      <button
        type="button"
        class="createmore-button bg-gray-50 py-2 px-10 flex gap-5 border border-gray-300 text-gray-900 text-sm rounded-lg"
      >
        More Settings<i class="ri-arrow-down-s-line"></i>
      </button>
    </div>
  </div>
  <div class="create-setting mt-4 flex flex-col gap-4 hidden">
    <div class="flex items-center">
      <div class="w-1/3">
        <label
          for="app-description"
          class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
          >Application description:<span class="text-red-500">*</span></label>
      </div>
      <div class="w-2/3">
        <input
          type="text"
          name="app_description"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2"
          placeholder="Please enter an application description"
          required
        />
      </div>
    </div>
    <div class="flex items-center">
      <div class="w-1/3">
        <label
          for="picture_icon"
          class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
          >Picture icon:<span class="text-red-500">*</span></label>
      </div>
      <div class="w-2/3">
        <input
          type="file"
          name="picture_icon"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2"
          placeholder="Select the picture or paste the web picture link"
          required
        />
      </div>
    </div>
    <div class="flex items-center">
      <div class="w-1/3">
        <label
          for="open_type"
          class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
          >Open type:<span class="text-red-500">*</span></label>
      </div>
      <div class="w-2/3">
        <input type="hidden" name="open_type" id="open_type" value="new_window">
        <button
          type="button"
          class="create-newbtn px-8 py-2 bg-gray-400 rounded-sm"
          onclick="setOpenType('new_window')"
        >
          New window
        </button>
        <button
          type="button"
          class="create-Dialog px-12 py-2 bg-gray-400 rounded-sm"
          onclick="setOpenType('dialog')"
        >
          Dialog
        </button>
      </div>
    </div>
    <div class="create-content flex flex-col gap-3 hidden">
      <div class="flex items-center">
        <div class="w-1/3">
          <label
            for="dialog_size"
            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >Dialog size:<span class="text-red-500">*</span></label>
        </div>
        <div class="w-2/3 flex items-center gap-3">
          <div
            class="flex items-center border-2 rounded-lg w-1/2 overflow-hidden bg-gray-200"
          >
            <input
              type="number"
              name="dialog_width"
              class="w-4/5 text-gray-900 text-sm outline-none border-none"
            />
            <h4 class="1/5 px-2">Width</h4>
          </div>
          <div
            class="flex items-center border-2 rounded-lg w-1/2 overflow-hidden bg-gray-200"
          >
            <input
              type="number"
              name="dialog_height"
              class="w-4/5 text-gray-900 text-sm outline-none border-none"
            />
            <h4 class="1/5 px-2">Height</h4>
          </div>
        </div>
      </div>
      <div class="flex items-center">
        <div class="w-1/3">
          <label
            for="more_settings"
            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >More settings:<span class="text-red-500">*</span></label>
        </div>
        <div class="w-2/3 flex items-center gap-3">
          <div class="flex items-center w-1/2 gap-2">
            <input
              type="checkbox"
              name="allow_width_adjustment"
              value="option1"
              class="outline-none focus:outline-none"
            />
            <h4>Allow width adjustment</h4>
          </div>
          <div class="flex items-center w-1/2 gap-2">
            <input
              type="checkbox"
              name="minimalist_title_bar"
              value="allow"
              class="outline-none focus:outline-none"
            />
            <h4>Minimalist title bar</h4>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="flex items-center justify-end gap-4 pt-16">
    <button
      type="button"
      class="text-blue-700 bg-white border border-blue-700 font-medium rounded-full text-sm px-8 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
    >
      Preview
    </button>
    <button
      type="submit"
      class="text-blue-700 bg-white border border-blue-700 font-medium rounded-full text-sm px-8 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
    >
      Submit
    </button>
  </div>
</form>

<script>
function setOpenType(value) {
  document.getElementById('open_type').value = value;
}
</script>
                  </div>
                </div>
              </div>
            </div>
            <div
              id="popup-modal"
              tabindex="-1"
              class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"
            >
  
              <div class="relative p-4 w-full max-w-md max-h-full">
    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <div class="p-4 md:p-5 text-center">
            <div class="delete-header flex items-center gap-4 border-b-2">
                <i class="ri-delete-bin-6-line text-yellow-400 text-2xl"></i>
                <h1 class="font-medium">Delete File</h1>
            </div>
            <div class="mt-4 flex items-center justify-center">
                <h1 class="text-md font-medium">
                    Are you sure you want to delete the selection?
                </h1>
            </div>
            <div class="flex items-center justify-center gap-3 mt-6">
                <form id="deleteForm" action="apps-delete/<?php echo @$data->id ?>" method="POST">
                    @csrf
                    @method('get')
                    

                     <button style="background-color: black; color: white; padding: 9px 64px; border-radius: 50px;"
                         type="submit"
                      > 
                        OK
                      </button>
                </form>
                 <button id="cancelButton" class="bg-white text-yellow-300 px-12 py-2 rounded-full border border-yellow-300" data-modal-hide="popup-modal">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    // Attach event listener to the Cancel button
    document.getElementById('cancelButton').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default form submission behavior
        // Implement cancellation logic here, such as closing the modal or redirecting
        console.log('Cancellation logic executed.');
    });
</script>

            </div>
          </div>
        </div>
      </div>
      <footer class="w-full h-14 flex items-center justify-between px-9">
        <button
          id="footerButton"
          class="text-black px-4 py-3 rounded-md hover:bg-black hover:text-white"
        >
          File
        </button>
        <img
          id="footer-logo"
          class="w-10 h-10"
          src="{{ asset($constants['IMAGEFILEPATH'].'logo.png')}}"
          alt="Logo"
        />
      </footer>
    </div>

    <script>
      const createMore = document.querySelector(".createmore-button");
      const createSetting = document.querySelector(".create-setting");
      const createDialog = document.querySelector(".create-Dialog");
      const createContent = document.querySelector(".create-content");
      const createNewbtn = document.querySelector(".create-newbtn")

      createMore.addEventListener("click", function () {
        createSetting.classList.toggle("hidden");
        createMore.style.backgroundColor = createSetting.classList.contains(
          "hidden"
        )
          ? ""
          : "orange";
      });

         createNewbtn.addEventListener("click", function() {
             createContent.classList.add("hidden");
                createNewbtn.style.backgroundColor = createNewbtn.style.backgroundColor === "orange" ? "" : "orange";
                createDialog.style.backgroundColor = ""; 
            });

      createDialog.addEventListener("click", function () {
        createContent.classList.toggle("hidden");
         createDialog.style.backgroundColor = createDialog.style.backgroundColor === "orange" ? "" : "orange";
                createNewbtn.style.backgroundColor = "";
      });

      //Dynamically added the containers


 const aa = JSON.parse('<?php echo $jsonData; ?>');
 
       const container = document.querySelector(".lightapp-content");
        const data = aa;

      data.forEach((item) => {
        console.log(item);
        const smallContainer = document.createElement("div");
        smallContainer.id = `${item.id}`;
        smallContainer.className =
          "small-container w-48 h-56 rounded-lg flex flex-col items-center justify-center gap-5";

        smallContainer.innerHTML = `
                <div class="img-container w-16 h-16 rounded-lg bg-white shadow-black flex items-center justify-center">
                    <img class="w-10 h-10" src="${item.image}" alt="${item.name} Image">
                </div>
                <h1 class="font-medium">${item.name}</h1>
                <div> 
                    <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown${item.id}" class="flex items-center justify-between gap-5 text-yellow-300 rounded-md text-lg py-2 px-8" type="button">Add  <i class="text-white ri-arrow-down-s-line"></i>
                    <a href="add-apps-desktop/"${item.name} </a>
                    </button>

                    <div id="dropdown${item.id}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                          <li>
                          <a ></a>
                            <a   
                           

   data-modal-target="Edit-modal${item.id}" 
   data-modal-toggle="Edit-modal${item.id}" 
   class="block w-full px-4 py-2 text-base hover:bg-yellow-400 hover:text-black flex gap-2"
>
    <i class="ri-edit-box-line"></i>Edit
</a>

                          </li>
                          <li>
                            
                            <button data-modal-target="popup-modal" data-modal-toggle="popup-modal" type="button" class="block w-full px-4 py-2 text-base hover:bg-yellow-400 hover:text-black flex gap-2"><i class="ri-delete-bin-6-line"></i>Delete

                           
                          </li>
                        </ul>
                    </div>
                </div>
                 <div id="Edit-modal${item.id}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-2xl max-h-full">
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <div class="flex items-center gap-4 p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                <div class="img-container w-14 h-14 rounded-lg bg-white shadow-black flex items-center justify-center">
                                        <img class="w-10 h-10" src="${item.image}" alt="${item.name} Image">
                                    </div>
                                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                                        ${item.name}
                                    </h3>
                                </div>
                                <a  href="apps-update/${item.id}"></a>
                                <div class="p-4 md:p-5 space-y-4">
                                    <form class="space-y-4" action="{{url('submit')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                        <div class="flex items-center">
                                          <div class="w-1/3">
                                             <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name:<span class="text-red-500">*</span></label>
                                          </div>
                                          <div class="w-2/3">
                                              <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-2 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Please enter an application name" value="{{ $data->name }}"required />
                                          </div>
                                        </div>
                                        <div class="flex items-center">
                                          <div class="w-1/3">
                                             <label for="website-link" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Website link:<span class="text-red-500">*</span></label>
                                          </div>
                                          <div class="w-2/3">
                                              <input type="text" name="website-link" id="website-link" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-2 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Please enter http / https link" required value="{{ $data->website_link }}"/>
                                          </div>
                                        </div>
                                      <div class="flex items-center">
                                        <div class="w-1/3">
                                           <label for="application-grouping" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Application grouping:<span class="text-red-500">*</span></label>
                                        </div>
                                        <div class="w-2/3">
                                            <select class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl " name="" id="">
                                              <option value="Tool">Tool</option>
                                            </select>
                                        </div>
                                           
                                          
                                      </div>
                                      <div class="flex items-center">
                                        <div class="w-1/3">

                                        </div>
                                        <div class="w-2/3">
                                           <button type="button" class="more-settings-button bg-gray-50 py-2 px-10 flex gap-5 border border-gray-300 text-gray-900 text-sm rounded-xl">More Settings<i class="ri-arrow-down-s-line"></i></button>
                                        </div>
                                           
                                      </div>
                                       <div class="more-setting mt-4 flex flex-col gap-4 hidden">
                                              <div class="flex items-center">
                                                <div class="w-1/3">
                                                   <label for="app-description"  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Application description:<span class="text-red-500">*</span></label>
                                                </div>
                                                <div class="w-2/3">
                                                   <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-2" placeholder="Please enter an application description" value="{{ $data->app_description }}" >
                                                </div>
                                              </div>
                                               <div class="flex items-center">
                                                <div class="w-1/3">
                                                     <label for="pictureicon" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Picture icon:<span class="text-red-500">*</span></label>
                                                </div>
                                                <div class="w-2/3 bg-gray-50 border border-gray-300 rounded-xl flex items-center overflow-hidden">
                                                     <input type="text" class="w-5/6 text-gray-900 text-sm p-2 focus:outline-none border-none" placeholder="Select the picture or paste the web picture link" >
                                                     <div class="w-1/6 ml-4">
                                                       <img class="w-8 h-8" src="{{ asset($constants['IMAGEFILEPATH'].'Folder.png')}}" alt="Folder Image">
                                                      </div>
                                                    
                                                </div>
                                              </div>
                                              <div class="flex items-center">
                                                <div class="w-1/3">
                                                     <label for="opentype"  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Open type:<span class="text-red-500">*</span></label>
                                                </div>
                                                <div class="w-2/3">
                                                  <button type="button" class="new-window-btn px-8 py-2 bg-gray-400 rounded-sm">New window</button>
                                                    <button type="button" class="Dialog-btn px-12 py-2 bg-gray-400 rounded-sm">Dialog</button>
                                                </div>
                                              </div>
                                              <div class="Dialog-content flex flex-col gap-3 hidden">
                                                  <div class="flex items-center">
                                                <div class="w-1/3">
                                                   <label for="dialogsize"  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dialog size:<span class="text-red-500">*</span></label>
                                                </div>
                                                <div class="w-2/3 flex items-center gap-3">
                                                  <div class="flex items-center border-2 rounded-xl w-1/2 overflow-hidden bg-gray-200">
                                                    <input type="number" name="width" class="w-4/5 text-gray-900 text-sm outline-none border-none ">
                                                    <h4 class="1/5 px-2">Width</h4>
                                                  </div>
                                                   <div class="flex items-center border-2 rounded-xl w-1/2 overflow-hidden bg-gray-200">
                                                    <input type="number" name="width" class="w-4/5 text-gray-900 text-sm outline-none border-none ">
                                                    <h4 class="1/5 px-2">Height</h4>
                                                  </div>
                                                </div>
                                              </div>
                                               <div class="flex items-center">
                                                <div class="w-1/3">
                                                   <label for="more-settings"  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">More settings:<span class="text-red-500">*</span></label>
                                                </div>
                                                <div class="w-2/3 flex items-center gap-3">
                                                  <div class="flex items-center w-1/2 gap-2">
                                                    <input type="checkbox" name="option" value="option1" class="outline-none focus:outline-none">
                                                    <h4>Allow width adjusment</h4>
                                                  </div>
                                                   <div class="flex items-center w-1/2 gap-2">
                                                    <input type="checkbox" name="option" value="option2" class="outline-none focus:outline-none">
                                                    <h4>Minimalist title bar</h4>
                                                  </div>
                                                </div>
                                              </div>
                                              </div>
                                             
                                       </div>
                                      <div class="flex items-center justify-end gap-4 pt-16">
                                        <button class="text-blue-500 bg-white border border-blue-500 font-medium rounded-full text-sm px-10 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Preview</button>
                                          <button class="bg-black text-white px-12 py-2 rounded-full">Save</button>
                                      </div>
                                    </form>
                                </div>
                            </div>
                        </div>
            </div>
            `;
        container.appendChild(smallContainer);

        const btn = smallContainer.querySelector(".more-settings-button");
        const dialogbtn = smallContainer.querySelector(".Dialog-btn");
         const newWindowBtn = smallContainer.querySelector(".new-window-btn");
        const moreSetting = smallContainer.querySelector(".more-setting");
        const dialogcontent = smallContainer.querySelector(".Dialog-content");

        btn.addEventListener("click", function () {
          moreSetting.classList.toggle("hidden");
          btn.style.backgroundColor = moreSetting.classList.contains("hidden")
            ? ""
            : "orange";
        });

          newWindowBtn.addEventListener("click", function() {
             dialogcontent.classList.add("hidden");
                newWindowBtn.style.backgroundColor = newWindowBtn.style.backgroundColor === "orange" ? "" : "orange";
                dialogbtn.style.backgroundColor = ""; 
            });

        dialogbtn.addEventListener("click", function () {
          dialogcontent.classList.toggle("hidden");
             dialogbtn.style.backgroundColor = dialogbtn.style.backgroundColor === "orange" ? "" : "orange";
                newWindowBtn.style.backgroundColor = "";
        });
      });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
  </body>
</html>
