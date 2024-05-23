<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multiple Tag Selection Example</title>
</head>
<body>

    <label for="tags">Select your tags (multiple selections allowed):</label><br>
    <select id="tags" name="tags[]" multiple onchange="updateSelectedTags()">
        <option value="tag1">Tag 1</option>
        <option value="tag2">Tag 2</option>
        <option value="tag3">Tag 3</option>
        <!-- Add more options as needed -->
    </select>

    <div id="selectedTags">Selected Tags: </div>

    <script>
        function updateSelectedTags() {
            var select = document.getElementById("tags");
            var selectedTags = document.getElementById("selectedTags");

            // Clear previous selections
            selectedTags.innerHTML = "Selected Tags: ";

            // Update selected tags
            for (var i = 0; i < select.options.length; i++) {
                if (select.options[i].selected) {
                    selectedTags.innerHTML += select.options[i].text + ", ";
                }
            }

            // Remove trailing comma and space
            selectedTags.innerHTML = selectedTags.innerHTML.slice(0, -2);
        }
    </script>

</body>
</html>
