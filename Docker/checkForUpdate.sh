if [[ `git status --porcelain` ]]; then
  git pull 
else
  # No changes
fi