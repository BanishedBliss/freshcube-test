import DangerButton from '@/Components/DangerButton';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import Modal from '@/Components/Modal';
import SecondaryButton from '@/Components/SecondaryButton';
import TextInput from '@/Components/TextInput';
import {useForm} from '@inertiajs/react';
import {useRef, useState} from 'react';

export default function DeleteUserForm({className = ''}) {
  const [confirmingUserDeletion, setConfirmingUserDeletion] = useState(false);
  const passwordInput = useRef();

  const {
    data,
    setData,
    delete: destroy,
    processing,
    reset,
    errors,
    clearErrors,
  } = useForm({
    password: '',
  });

  const confirmUserDeletion = () => {
    setConfirmingUserDeletion(true);
  };

  const deleteUser = (e) => {
    e.preventDefault();

    destroy(route('profile.destroy'), {
      preserveScroll: true,
      onSuccess: () => closeModal(),
      onError: () => passwordInput.current.focus(),
      onFinish: () => reset(),
    });
  };

  const closeModal = () => {
    setConfirmingUserDeletion(false);

    clearErrors();
    reset();
  };

  return (
    <section className={`space-y-6 ${className}`}>
      <header>
        <h2 className="text-lg font-medium text-gray-900 dark:text-gray-100">
          Удалить аккаунт
        </h2>

        <p className="mt-1 text-sm text-gray-600 dark:text-gray-400">
          После удаления Вашего аккаунта, все связанные с ним ресурсы и данные
          будут полностью стёрты. Перед удалением, пожалуйста скачайте
          все данные, которые Вы хотите сохранить!
        </p>
      </header>

      <DangerButton onClick={confirmUserDeletion}>
        Удалить аккаунт
      </DangerButton>

      <Modal show={confirmingUserDeletion} onClose={closeModal}>
        <form onSubmit={deleteUser} className="p-6">
          <h2 className="text-lg font-medium text-gray-900 dark:text-gray-100">
            Вы уверены, что хотите удалить аккаунт?
          </h2>

          <p className="mt-1 text-sm text-gray-600 dark:text-gray-400">
            После удаления Вашего аккаунта, все связанные с ним ресурсы и данные
            будут полностью стёрты. Пожалуйста, введите Ваш пароль, чтобы
            подтвердить удаление аккаунта.
          </p>

          <div className="mt-6">
            <InputLabel
              htmlFor="password"
              value="Пароль"
              className="sr-only"
            />

            <TextInput
              id="password"
              type="password"
              name="password"
              ref={passwordInput}
              value={data.password}
              onChange={(e) =>
                setData('password', e.target.value)
              }
              className="mt-1 block w-3/4"
              isFocused
              placeholder="Пароль"
            />

            <InputError
              message={errors.password}
              className="mt-2"
            />
          </div>

          <div className="mt-6 flex justify-end">
            <SecondaryButton onClick={closeModal}>
              Отмена
            </SecondaryButton>

            <DangerButton className="ms-3" disabled={processing}>
              Удалить аккаунт
            </DangerButton>
          </div>
        </form>
      </Modal>
    </section>
  );
}
