# TODO

## Topics enhancements
- [ ] Add filter/sort capable query to `TopicModel` (chapter filter + statute/legal_provision filter + sorting)
- [ ] Update `TopicController@index` to read query params and pass filtered/sorted topics + dashboard dataset
- [ ] Update `app/Views/topics/index.php` with filter UI (chapter dropdown + statute text search) and topics-wise dashboard panel
- [ ] Ensure topic list table shows mapped statute/provision count when filtered
- [ ] Smoke test routes:
  - [ ] `/topics` (default)
  - [ ] `/topics?chapter_id=...`
  - [ ] `/topics?provision_query=...`
  - [ ] verify sort via URL params

