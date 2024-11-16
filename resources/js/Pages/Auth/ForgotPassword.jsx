import InputError from '@/Components/InputError';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import GuestLayout from '@/Layouts/GuestLayout';
import {Head, useForm} from '@inertiajs/react';

export default function ForgotPassword({status}) {
  const {data, setData, post, processing, errors} = useForm({
    email: '',
  });

  const submit = (e) => {
    e.preventDefault();

    post(route('password.email'));
  };

  return (
    <GuestLayout>
      <Head title="Восстановление пароля"/>

      <div className="mb-4 text-sm text-gray-600 dark:text-gray-400">
        Забыли Ваш пароль? Не проблема. Просто подтвердите, что
        помните Ваш email и мы отправим Вам ссылку на восстановление
        пароля, которая позволит Вам ввести новый.
      </div>

      {status && (
        <div className="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
          {status}
        </div>
      )}

      <form onSubmit={submit}>
        <TextInput
          id="email"
          type="email"
          name="email"
          value={data.email}
          className="mt-1 block w-full"
          isFocused={true}
          onChange={(e) => setData('email', e.target.value)}
        />

        <InputError message={errors.email} className="mt-2"/>

        <div className="mt-4 flex items-center justify-end">
          <PrimaryButton className="ms-4" disabled={processing}>
            Восстановить пароль
          </PrimaryButton>
        </div>
      </form>
    </GuestLayout>
  );
}
