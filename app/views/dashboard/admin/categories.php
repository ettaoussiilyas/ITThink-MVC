<?php

    // add or modify category code
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["add_modify_category"])) {
            $category_name = trim($_POST["category_name_input"]);
            $category_id = isset($_POST["category_id_input"]) ? trim($_POST["category_id_input"]) : '';

            if (!empty($category_name)) {
                // create a new category if id not gived
                if($category_id==0){
                    try {
                        $AddCategoryQuery = $conn->prepare("INSERT INTO categories (nom_categorie) VALUES (:category_name)");
                        $AddCategoryQuery->execute([':category_name' => $category_name]);
    
                    } catch (PDOException $e) {
                        echo "Database Error: " . $e->getMessage();
                    }
                }
                // modify category if id gived
                else{
                    try {
                        $modifyCategoryQuery = $conn->prepare("UPDATE categories SET nom_categorie = ? WHERE id_categorie = ?");
                        $modifyCategoryQuery->execute([$category_name,$category_id]);
    
                    } catch (PDOException $e) {
                        echo "Database Error: " . $e->getMessage();
                    }
                }
                
            } 
        } 
    }

    // add or modify subcategory code
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["add_modify_subcategory"])) {
            $subcategory_name = trim($_POST["subcategory_name_input"]);
            $category_id = $_POST["category_parent_id_input"];
            $subcategory_id = (int)trim($_POST["subcategory_id_input"]);
            

            if (!empty($subcategory_name)) {
                // create a new subcategory if id not gived
                if($subcategory_id==0){
                    try {
                        $AddSubCategoryQuery = $conn->prepare("INSERT INTO sous_categories (nom_sous_categorie, id_categorie) VALUES (:subcategory_name, :category_id)");
                        $AddSubCategoryQuery->execute([':subcategory_name' => $subcategory_name,':category_id' => $category_id]);

    
                    } catch (PDOException $e) {
                        echo "Database Error: " . $e->getMessage();
                    }
                }
                // modify subcategory if id gived
                else{
                    try {
                        $modifySubCategoryQuery = $conn->prepare("UPDATE sous_categories SET nom_sous_categorie = ? WHERE id_sous_categorie = ?");
                        $modifySubCategoryQuery->execute([$subcategory_name,$subcategory_id]);
    
                    } catch (PDOException $e) {
                        echo "Database Error: " . $e->getMessage();
                    }
                }
                
            } 
        } 
    }

?>
<?php require_once(__DIR__.'/../../partials/header.php');?>


    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
        <section class="p-8 antialiased md:py-16">
            <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
                <div class="mb-4 flex items-center justify-between gap-4 md:mb-8">
                            <h2 class="text-xl font-semibold text-gray-900 sm:text-2xl">Categories</h2>
                            <button id="add_categorie_button" class="text-gray-100 bg-gray-900 hover:bg-gray-700 p-3 mb-5 mr-5 rounded-sm">Add Categorie</button>
                </div>
                <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    <?php foreach ($categories as $category): ?>
                        <div class="category_box flex flex-col rounded-lg border border-gray-200 bg-white px-4 py-4 hover:bg-gray-50" data-category-id="<?= $category['id_categorie']?>">
                            <h3 class="text-xl font-semibold text-gray-900 sm:text-2xl text-center"><?= $category['nom_categorie']?></h3>
                            <div class="flex justify-between my-4">
                                <h3 class="font-semibold text-gray-900">Subcategories:</h3>
                                <button type="button" class="add_sub_cat" title="Add subcategory" id="add_sub_category">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 12H20M12 4V20" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </div>
                                <!-- Display subcategories if they exist -->
                            <div id="sub_cats_container">
                                <?php if (!empty($category['sous_categories'])): ?>
                                        <?php foreach ($category['sous_categories'] as $subCategory): ?>
                                            <div class="sub_cat_box ml-2 border-2 border-gray-200 px-2 py-1 mb-2 rounded-lg flex justify-between" data-sub-category-id="<?= $subCategory['id_sous_categorie'] ?>">
                                                <span class="sub_cat_name"><?= htmlspecialchars($subCategory['nom_sous_categorie']) ?></span>
                                                <div class="flex">
                                                    <button class="modify_sub_cat">
                                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                    </button>
                                                    <form action="/remove/cat-subcat" method="POST">
                                                        <input type="text" value="<?= $subCategory['id_sous_categorie'] ?>" class="hidden" name="id_type">
                                                        <button type="submit" class="remove_sub_cat ml-2" name="delete" value="sub_category">
                                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 7H20" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M6 7V18C6 19.6569 7.34315 21 9 21H15C16.6569 21 18 19.6569 18 18V7" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                        </button>
                                                    </form>
                                                    
                                                </div>
                                            </div>
                                            
                                        <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="mt-2 text-sm text-gray-500">No subcategories available.</p>
                                <?php endif; ?>
                            </div>
                            <div class="flex justify-between items-end mt-auto mx-2 pt-5">
                                <button class="modify_category_button">Modify</button>
                                <!-- delete category -->
                                <form action="/remove/cat-subcat" method="POST">
                                    <input type="text" value="<?= $category['id_categorie']?>" class="hidden" name="id_type">
                                    <input type="hidden" value="category" name="delete" placeholder="Delete">
                                    <input type="submit" value="Delete" >
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                        
                </div>
            </div>
        </section>

        <script src="/assets/js/categories.js"></script>
        <script data-cfasync="false" src="https://www.creative-tim.com/twcomponents/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
        <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"8e2ed63ffe793144","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"version":"2024.10.5","token":"1b7cbb72744b40c580f8633c6b62637e"}' crossorigin="anonymous"></script>
    </main>

<?php require_once(__DIR__.'/../../partials/footer.php');?>