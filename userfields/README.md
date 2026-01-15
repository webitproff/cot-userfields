# userfields-cotonti
## User Fields
### Custom user fields management without extra fields in modules CMF Cotonti

Плагин Userfields для CMS Cotonti позволяет создавать и управлять дополнительными пользовательскими полями (например, номер телефона, название компании, адрес, телеграм) без изменения таблицы cot_users. 
Использует таблицы cot_userfield_types (типы полей) и cot_userfield_values (значения полей) для масштабируемости и удобства. 
Поля интегрируются в профили пользователей, админ-панель и шаблоны (список пользователей, статьи, форумы, модуль Market PRO, Multistore).


```
`users.details.tpl`, `users.details.contractor.tpl`, `users.contractor.tpl`, `users.tpl`

<!-- IF {PHP|cot_plugin_active('userfields')} -->						
<div class="row mb-3">
	<div class="list-group list-group-striped list-group-flush mb-4">
		<!-- IF {USERFIELDS_COMPANY_NAME} -->
		<li class="list-group-item list-group-item-action ">
			<div class="row g-3">
				<div class="col-12 col-lg-4">
					<h5 class="mb-0 fs-6 text-secondary fw-semibold">
						{USERFIELDS_COMPANY_NAME_TITLE}
					</h5>
				</div>
				<div class="col-12 col-lg-8">
					<div>
						<p><i class="fa-solid fa-building me-2"></i>{USERFIELDS_COMPANY_NAME}</p>
					</div>
				</div>
			</div>
		</li>
		<!-- ENDIF -->
		<!-- IF {USERFIELDS_PROMO_TEXT} -->
		<li class="list-group-item list-group-item-action ">
			<div class="row g-3">
				<div class="col-12 col-lg-4">
					<h5 class="mb-0 fs-6 text-secondary fw-semibold">
						{USERFIELDS_PROMO_TEXT_TITLE}
					</h5>
				</div>
				<div class="col-12 col-lg-8">
					<div>
						<p><i class="fa-solid fa-list-check fa-lg me-2"></i>{USERFIELDS_PROMO_TEXT}</p>
					</div>
				</div>
			</div>
		</li>
		<!-- ENDIF -->
		<!-- IF {USERFIELDS_GITHUB} -->
		<li class="list-group-item list-group-item-action ">
			<div class="row g-3">
				<div class="col-12 col-lg-4">
					<h5 class="mb-0 fs-6 text-secondary fw-semibold">
						{USERFIELDS_GITHUB_TITLE}
					</h5>
				</div>
				<div class="col-12 col-lg-8">
					<div>
						<a rel="noopener noreferrer" href="https://github.com/{USERFIELDS_GITHUB}" target="_blank" class="fw-semibold">
							<i class="fa-brands fa-square-github fa-xl me-2"></i>{PHP.L.userfields_github_details}
						</a>
					</div>
				</div>
			</div>
		</li>
		<!-- ENDIF -->
		<!-- IF {USERFIELDS_TELEGRAM} -->
		<li class="list-group-item list-group-item-action ">
			<div class="row g-3">
				<div class="col-12 col-lg-4">
					<h5 class="mb-0 fs-6 text-secondary fw-semibold">
						{USERFIELDS_TELEGRAM_TITLE}
					</h5>
				</div>
				<div class="col-12 col-lg-8">
					<div>
						<a rel="noopener noreferrer" href="https://t.me/{USERFIELDS_TELEGRAM}" target="_blank" class="fw-semibold">
							<i class="fa-brands fa-telegram fa-xl me-2"></i>{PHP.L.userfields_telegram_details}
						</a>
					</div>
				</div>
			</div>
		</li>
		<!-- ENDIF -->
		<!-- IF {USERFIELDS_CELL_NUMBER} -->
		<li class="list-group-item list-group-item-action ">
			<div class="row g-3">
				<div class="col-12 col-lg-4">
					<h5 class="mb-0 fs-6 text-secondary fw-semibold">
						{USERFIELDS_CELL_NUMBER_TITLE}
					</h5>
				</div>
				<div class="col-12 col-lg-8">
					<div>
						<a rel="noopener noreferrer" href="tel:{USERFIELDS_CELL_NUMBER}" class="fw-semibold">
							<i class="fa-solid fa-phone-volume fa-xl me-2"></i>{USERFIELDS_CELL_NUMBER}
						</a>
					</div>
				</div>
			</div>
		</li>
		<!-- ENDIF -->
	</div>
</div>
<!-- ENDIF -->
```
`users.edit.tpl`
```
<!-- IF {PHP|cot_plugin_active('userfields')} -->
<hr>
<h2 class="h5 mb-2"><i class="fa-solid fa-wand-magic-sparkles fa-xl me-3 text-hot"></i>{PHP.L.userfields_userfields}</h2>
<div class="row mb-3">
	<!-- IF {USERFIELDS_TELEGRAM} -->
	<div class="mb-3 row">
		<label class="col-sm-3 col-form-label">{USERFIELDS_TELEGRAM_TITLE}:</label>
		<div class="col-sm-9 pt-2">{USERFIELDS_TELEGRAM}</div>
	</div>
	<!-- ENDIF -->
	<!-- IF {USERFIELDS_CELL_NUMBER} -->
	<div class="mb-3 row">
		<label class="col-sm-3 col-form-label">{USERFIELDS_CELL_NUMBER_TITLE}:</label>
		<div class="col-sm-9 pt-2">{USERFIELDS_CELL_NUMBER}</div>
	</div>
	<!-- ENDIF -->
	
	<!-- IF {USERFIELDS_COMPANY_NAME} -->
	<div class="mb-3 row">
		<label class="col-sm-3 col-form-label">{USERFIELDS_COMPANY_NAME_TITLE}:</label>
		<div class="col-sm-9 pt-2">{USERFIELDS_COMPANY_NAME}</div>
	</div>
	<!-- ENDIF -->
	<!-- IF {USERFIELDS_PROMO_TEXT} -->
	<div class="mb-3 row">
		<div  class="col-sm-3">
			<label class="col-form-label">{USERFIELDS_PROMO_TEXT_TITLE}:</label>
			<div class="small text-muted">{PHP.L.userfields_promo_text_profile}</div>
		</div>
		<div class="col-sm-9 pt-2">{USERFIELDS_PROMO_TEXT}
			<div class="small text-muted">{PHP.L.userfields_promo_text_profile_hint}</div>
		</div>
	</div>
	<!-- ENDIF -->
	<!-- IF {USERFIELDS_GITHUB} -->
	<div class="mb-3 row">
		<div  class="col-sm-3">
			<label class="col-form-label">{USERFIELDS_GITHUB_TITLE}:</label>
			<div class="small text-muted">{PHP.L.userfields_github_profile}</div>
		</div>
		<div class="col-sm-9 pt-2">{USERFIELDS_GITHUB}
			<div class="small text-muted">{PHP.L.userfields_github_profile_hint}</div>
		</div>
	</div>
	<!-- ENDIF -->
</div>
<hr>
<!-- ENDIF -->
```

`users.edit.tpl`

```
<!-- IF {PHP|cot_plugin_active('userfields')} -->
<hr>
<h2 class="h5 mb-2"><i class="fa-solid fa-wand-magic-sparkles fa-xl me-3 text-hot"></i>{PHP.L.userfields_userfields}</h2>
<div class="row mb-3">
	<!-- IF {USERFIELDS_TELEGRAM} -->
	<div class="mb-3 row">
		<label class="col-sm-3 col-form-label">{USERFIELDS_TELEGRAM_TITLE}:</label>
		<div class="col-sm-9 pt-2">{USERFIELDS_TELEGRAM}</div>
	</div>
	<!-- ENDIF -->
	<!-- IF {USERFIELDS_CELL_NUMBER} -->
	<div class="mb-3 row">
		<label class="col-sm-3 col-form-label">{USERFIELDS_CELL_NUMBER_TITLE}:</label>
		<div class="col-sm-9 pt-2">{USERFIELDS_CELL_NUMBER}</div>
	</div>
	<!-- ENDIF -->
	
	<!-- IF {USERFIELDS_COMPANY_NAME} -->
	<div class="mb-3 row">
		<label class="col-sm-3 col-form-label">{USERFIELDS_COMPANY_NAME_TITLE}:</label>
		<div class="col-sm-9 pt-2">{USERFIELDS_COMPANY_NAME}</div>
	</div>
	<!-- ENDIF -->
	<!-- IF {USERFIELDS_PROMO_TEXT} -->
	<div class="mb-3 row">
		<div  class="col-sm-3">
			<label class="col-form-label">{USERFIELDS_PROMO_TEXT_TITLE}:</label>
			<div class="small text-muted">{PHP.L.userfields_promo_text_profile}</div>
		</div>
		<div class="col-sm-9 pt-2">{USERFIELDS_PROMO_TEXT}
			<div class="small text-muted">{PHP.L.userfields_promo_text_profile_hint}</div>
		</div>
	</div>
	<!-- ENDIF -->
	<!-- IF {USERFIELDS_GITHUB} -->
	<div class="mb-3 row">
		<div  class="col-sm-3">
			<label class="col-form-label">{USERFIELDS_GITHUB_TITLE}:</label>
			<div class="small text-muted">{PHP.L.userfields_github_profile}</div>
		</div>
		<div class="col-sm-9 pt-2">{USERFIELDS_GITHUB}
			<div class="small text-muted">{PHP.L.userfields_github_profile_hint}</div>
		</div>
	</div>
	<!-- ENDIF -->
</div>
<hr>
<!-- ENDIF -->
```




`market.tpl`

```
<!-- IF {PHP|cot_plugin_active('userfields')} -->				
<div class="row mb-3">
	<div class="list-group list-group-striped list-group-flush mb-4">
		<!-- IF {USERFIELDS_PROMO_TEXT} -->
		<li class="list-group-item list-group-item-action ">
			<div class="row g-3">
				<div class="col-12">
					<h5 class="mb-0 fs-6 text-secondary fw-semibold">
						{USERFIELDS_PROMO_TEXT_TITLE}
					</h5>
				</div>
				<div class="col-12">
					<div>
						<p><i class="fa-solid fa-list-check fa-lg me-2"></i><small>{USERFIELDS_PROMO_TEXT}</small></p>
					</div>
				</div>
			</div>
		</li>
		<!-- ENDIF -->
		<!-- IF {USERFIELDS_GITHUB} -->
		<li class="list-group-item list-group-item-action ">
			<div class="row g-3">
				<div class="col-12">
					<h5 class="mb-0 fs-6 text-secondary">
						{USERFIELDS_GITHUB_TITLE}
					</h5>
				</div>
				<div class="col-12">
					<div>
						<a rel="noopener noreferrer" href="https://github.com/{USERFIELDS_GITHUB}" target="_blank" class="fw-semibold">
							<i class="fa-brands fa-square-github fa-xl me-2"></i>{PHP.L.userfields_github_details}
						</a>
					</div>
				</div>
			</div>
		</li>
		<!-- ENDIF -->
		<!-- IF {USERFIELDS_TELEGRAM} -->
		<li class="list-group-item list-group-item-action ">
			<div class="row g-3">
				<div class="col-12">
					<h5 class="mb-0 fs-6 text-secondary">
						{USERFIELDS_TELEGRAM_TITLE}
					</h5>
				</div>
				<div class="col-12">
					<div>
						<a rel="noopener noreferrer" href="https://t.me/{USERFIELDS_TELEGRAM}" target="_blank" class="fw-semibold">
							<i class="fa-brands fa-telegram fa-xl me-2"></i>{PHP.L.userfields_telegram_details}
						</a>
					</div>
				</div>
			</div>
		</li>
		<!-- ENDIF -->
	</div>
</div>
<!-- ENDIF -->
```

`market.list.tpl`

```
<!-- IF {PHP|cot_plugin_active('userfields')} -->				
<div class="row mb-3">
	<div class="list-group list-group-striped list-group-flush mb-4">
		<!-- IF {USERFIELDS_PROMO_TEXT} -->
		<li class="list-group-item list-group-item-action ">
			<div class="row g-3">
				<div class="col-12">
					<h5 class="mb-0 fs-6 text-secondary fw-semibold">
						{USERFIELDS_PROMO_TEXT_TITLE}
					</h5>
				</div>
				<div class="col-12">
					<div>
						<p><i class="fa-solid fa-list-check fa-lg me-2"></i><small>{USERFIELDS_PROMO_TEXT}</small></p>
					</div>
				</div>
			</div>
		</li>
		<!-- ENDIF -->
		<!-- IF {USERFIELDS_GITHUB} -->
		<li class="list-group-item list-group-item-action ">
			<div class="row g-3">
				<div class="col-12">
					<h5 class="mb-0 fs-6 text-secondary">
						{USERFIELDS_GITHUB_TITLE}
					</h5>
				</div>
				<div class="col-12">
					<div>
						<a rel="noopener noreferrer" href="https://github.com/{USERFIELDS_GITHUB}" target="_blank" class="fw-semibold">
							<i class="fa-brands fa-square-github fa-xl me-2"></i>{PHP.L.userfields_github_details}
						</a>
					</div>
				</div>
			</div>
		</li>
		<!-- ENDIF -->
		<!-- IF {USERFIELDS_TELEGRAM} -->
		<li class="list-group-item list-group-item-action ">
			<div class="row g-3">
				<div class="col-12">
					<h5 class="mb-0 fs-6 text-secondary">
						{USERFIELDS_TELEGRAM_TITLE}
					</h5>
				</div>
				<div class="col-12">
					<div>
						<a rel="noopener noreferrer" href="https://t.me/{USERFIELDS_TELEGRAM}" target="_blank" class="fw-semibold">
							<i class="fa-brands fa-telegram fa-xl me-2"></i>{PHP.L.userfields_telegram_details}
						</a>
					</div>
				</div>
			</div>
		</li>
		<!-- ENDIF -->
	</div>
</div>
<!-- ENDIF -->
```


`page.tpl`

```
<!-- IF {PHP|cot_plugin_active('userfields')} -->				
<div class="row mb-3">
	<div class="list-group list-group-striped list-group-flush mb-4">
		<!-- IF {USERFIELDS_PROMO_TEXT} -->
		<li class="list-group-item list-group-item-action ">
			<div class="row g-3">
				<div class="col-12">
					<h5 class="mb-0 fs-6 text-secondary fw-semibold">
						{USERFIELDS_PROMO_TEXT_TITLE}
					</h5>
				</div>
				<div class="col-12">
					<div>
						<p><i class="fa-solid fa-list-check fa-lg me-2"></i><small>{USERFIELDS_PROMO_TEXT}</small></p>
					</div>
				</div>
			</div>
		</li>
		<!-- ENDIF -->
		<!-- IF {USERFIELDS_GITHUB} -->
		<li class="list-group-item list-group-item-action ">
			<div class="row g-3">
				<div class="col-12">
					<h5 class="mb-0 fs-6 text-secondary">
						{USERFIELDS_GITHUB_TITLE}
					</h5>
				</div>
				<div class="col-12">
					<div>
						<a rel="noopener noreferrer" href="https://github.com/{USERFIELDS_GITHUB}" target="_blank" class="fw-semibold">
							<i class="fa-brands fa-square-github fa-xl me-2"></i>{PHP.L.userfields_github_details}
						</a>
					</div>
				</div>
			</div>
		</li>
		<!-- ENDIF -->
		<!-- IF {USERFIELDS_TELEGRAM} -->
		<li class="list-group-item list-group-item-action ">
			<div class="row g-3">
				<div class="col-12">
					<h5 class="mb-0 fs-6 text-secondary">
						{USERFIELDS_TELEGRAM_TITLE}
					</h5>
				</div>
				<div class="col-12">
					<div>
						<a rel="noopener noreferrer" href="https://t.me/{USERFIELDS_TELEGRAM}" target="_blank" class="fw-semibold">
							<i class="fa-brands fa-telegram fa-xl me-2"></i>{PHP.L.userfields_telegram_details}
						</a>
					</div>
				</div>
			</div>
		</li>
		<!-- ENDIF -->
	</div>
</div>
<!-- ENDIF -->
```

`page.list.tpl`

```
<!-- IF {PHP|cot_plugin_active('userfields')} -->				
<div class="row mb-3">
	<div class="list-group list-group-striped list-group-flush mb-4">
		<!-- IF {USERFIELDS_PROMO_TEXT} -->
		<li class="list-group-item list-group-item-action ">
			<div class="row g-3">
				<div class="col-12">
					<h5 class="mb-0 fs-6 text-secondary fw-semibold">
						{USERFIELDS_PROMO_TEXT_TITLE}
					</h5>
				</div>
				<div class="col-12">
					<div>
						<p><i class="fa-solid fa-list-check fa-lg me-2"></i><small>{USERFIELDS_PROMO_TEXT}</small></p>
					</div>
				</div>
			</div>
		</li>
		<!-- ENDIF -->
		<!-- IF {USERFIELDS_GITHUB} -->
		<li class="list-group-item list-group-item-action ">
			<div class="row g-3">
				<div class="col-12">
					<h5 class="mb-0 fs-6 text-secondary">
						{USERFIELDS_GITHUB_TITLE}
					</h5>
				</div>
				<div class="col-12">
					<div>
						<a rel="noopener noreferrer" href="https://github.com/{USERFIELDS_GITHUB}" target="_blank" class="fw-semibold">
							<i class="fa-brands fa-square-github fa-xl me-2"></i>{PHP.L.userfields_github_details}
						</a>
					</div>
				</div>
			</div>
		</li>
		<!-- ENDIF -->
		<!-- IF {USERFIELDS_TELEGRAM} -->
		<li class="list-group-item list-group-item-action ">
			<div class="row g-3">
				<div class="col-12">
					<h5 class="mb-0 fs-6 text-secondary">
						{USERFIELDS_TELEGRAM_TITLE}
					</h5>
				</div>
				<div class="col-12">
					<div>
						<a rel="noopener noreferrer" href="https://t.me/{USERFIELDS_TELEGRAM}" target="_blank" class="fw-semibold">
							<i class="fa-brands fa-telegram fa-xl me-2"></i>{PHP.L.userfields_telegram_details}
						</a>
					</div>
				</div>
			</div>
		</li>
		<!-- ENDIF -->
	</div>
</div>
<!-- ENDIF -->
```
`forums.posts.tpl`
```
<!-- IF {PHP|cot_plugin_active('userfields')} AND {USERFIELDS_ROWS_HTML} -->						
<div class="row mb-3">
	<div class="list-group list-group-striped list-group-flush mb-4">
		<!-- IF {USERFIELDS_COMPANY_NAME} -->
		<li class="list-group-item list-group-item-action ">
			<div class="row g-3">
				<div class="col-12 col-lg-4">
					<h5 class="mb-0 fs-6 text-secondary fw-semibold">
						{USERFIELDS_COMPANY_NAME_TITLE}
					</h5>
				</div>
				<div class="col-12 col-lg-8">
					<div>
						<p><i class="fa-solid fa-building me-2"></i>{USERFIELDS_COMPANY_NAME}</p>
					</div>
				</div>
			</div>
		</li>
		<!-- ENDIF -->
		<!-- IF {USERFIELDS_PROMO_TEXT} -->
		<li class="list-group-item list-group-item-action ">
			<div class="row g-3">
				<div class="col-12 col-lg-4">
					<h5 class="mb-0 fs-6 text-secondary fw-semibold">
						{USERFIELDS_PROMO_TEXT_TITLE}
					</h5>
				</div>
				<div class="col-12 col-lg-8">
					<div>
						<p><i class="fa-solid fa-list-check fa-lg me-2"></i>{USERFIELDS_PROMO_TEXT}</p>
					</div>
				</div>
			</div>
		</li>
		<!-- ENDIF -->
		<!-- IF {USERFIELDS_GITHUB} -->
		<li class="list-group-item list-group-item-action ">
			<div class="row g-3">
				<div class="col-12 col-lg-4">
					<h5 class="mb-0 fs-6 text-secondary fw-semibold">
						{USERFIELDS_GITHUB_TITLE}
					</h5>
				</div>
				<div class="col-12 col-lg-8">
					<div>
						<a rel="noopener noreferrer" href="https://github.com/{USERFIELDS_GITHUB}" target="_blank" class="fw-semibold">
							<i class="fa-brands fa-square-github fa-xl me-2"></i>{PHP.L.userfields_github_details}
						</a>
					</div>
				</div>
			</div>
		</li>
		<!-- ENDIF -->
		<!-- IF {USERFIELDS_TELEGRAM} -->
		<li class="list-group-item list-group-item-action ">
			<div class="row g-3">
				<div class="col-12 col-lg-4">
					<h5 class="mb-0 fs-6 text-secondary fw-semibold">
						{USERFIELDS_TELEGRAM_TITLE}
					</h5>
				</div>
				<div class="col-12 col-lg-8">
					<div>
						<a rel="noopener noreferrer" href="https://t.me/{USERFIELDS_TELEGRAM}" target="_blank" class="fw-semibold">
							<i class="fa-brands fa-telegram fa-xl me-2"></i>{PHP.L.userfields_telegram_details}
						</a>
					</div>
				</div>
			</div>
		</li>
		<!-- ENDIF -->
		<!-- IF {USERFIELDS_CELL_NUMBER} -->
		<li class="list-group-item list-group-item-action ">
			<div class="row g-3">
				<div class="col-12 col-lg-4">
					<h5 class="mb-0 fs-6 text-secondary fw-semibold">
						{USERFIELDS_CELL_NUMBER_TITLE}
					</h5>
				</div>
				<div class="col-12 col-lg-8">
					<div>
						<a rel="noopener noreferrer" href="tel:{USERFIELDS_CELL_NUMBER}" class="fw-semibold">
							<i class="fa-solid fa-phone-volume fa-xl me-2"></i>{USERFIELDS_CELL_NUMBER}
						</a>
					</div>
				</div>
			</div>
		</li>
		<!-- ENDIF -->
	</div>
</div>
<!-- ENDIF -->
```
