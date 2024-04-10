cd /git/directory
if [[ ?? updateGit.sh ]]; then
  git pull 
else
  # No changes
fi
