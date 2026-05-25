import sys
with open('resources/views/chat/groups/group_chat.blade.php', 'r', encoding='utf-8') as f:
    lines = f.readlines()

# 1. Change active_group_chat_content to flex-row and add main column wrapper
for i in range(len(lines)):
    if 'id="active_group_chat_content"' in lines[i]:
        lines[i] = lines[i].replace('flex-col', 'flex-row')
        lines.insert(i + 1, '    <!-- Main Chat Column -->\n    <div id="group_chat_main_column" class="flex-1 flex flex-col relative h-full min-w-0">\n')
        break

# 2. Find the flex row wrapper and remove it
flex_row_idx = -1
for i in range(len(lines)):
    if '<!-- Main Container Row including Chat list and right-side drawers -->' in lines[i]:
        flex_row_idx = i
        break

if flex_row_idx != -1:
    # Delete the comment and the div
    lines.pop(flex_row_idx)
    lines.pop(flex_row_idx)
    # also remove empty line if there is one
    if lines[flex_row_idx].strip() == '':
        lines.pop(flex_row_idx)

# 3. Find the sidebars and move them to the end of the file, just before the closing of active_group_chat_content
search_drawer_start = -1
for i in range(len(lines)):
    if '<!-- Group Search Drawer (Hidden by default) -->' in lines[i]:
        search_drawer_start = i
        break

# Find the closing of the flex row (which was originally line 695)
flex_row_end = -1
for i in range(search_drawer_start, len(lines)):
    if '<!-- Footer with Emoji, Attachment, Reply and Input -->' in lines[i]:
        # The closing div is a few lines before this
        for j in range(i-1, i-10, -1):
            if '</div>' in lines[j]:
                flex_row_end = j
                break
        break

sidebars_content = lines[search_drawer_start:flex_row_end+1]
# Remove sidebars from their original location
del lines[search_drawer_start:flex_row_end+1]

# 4. Find the end of active_group_chat_content (the footer closing div)
footer_end = -1
for i in range(len(lines)-1, -1, -1):
    if '<!-- Add Group Member Modal -->' in lines[i]:
        # Go up to find the closing div of active_group_chat_content
        for j in range(i-1, -1, -1):
            if '</div>' in lines[j]:
                footer_end = j
                break
        break

# Insert the sidebars before the closing of active_group_chat_content
# Wait, we added an extra wrapper (group_chat_main_column).
# So we need to CLOSE group_chat_main_column AFTER the footer, THEN insert sidebars, THEN active_group_chat_content closes.

# So at footer_end, we insert:
# </div> <!-- close group_chat_main_column -->
# [sidebars_content]
# And we don't need the closing div from sidebars_content because we just use it as the closing div for the sidebars themselves.
# Wait! In the original code, flex_row_end was the closing div for <div class="flex-1 flex overflow-hidden relative">.
# We deleted the opening of that div. So sidebars_content has an EXTRA closing div at the end!
# We can just use that extra closing div to close group_chat_main_column instead!
# So we just insert sidebars_content BEFORE the footer? No, sidebars must be AFTER the main column.
# Let's clean up sidebars_content: remove the last '</div>' which was for the flex row.
while sidebars_content and '</div>' in sidebars_content[-1]:
    sidebars_content.pop()

# Now insert closing of main column, then sidebars, before active_group_chat_content closes.
insertion_idx = footer_end
lines.insert(insertion_idx, '    </div> <!-- Close group_chat_main_column -->\n')
for line in reversed(sidebars_content):
    lines.insert(insertion_idx + 1, line)

with open('resources/views/chat/groups/group_chat.blade.php', 'w', encoding='utf-8') as f:
    f.writelines(lines)
print("Done")
